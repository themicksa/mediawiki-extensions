<?php
/**
 * ApiFlagFeedbackArticleFeedbackv5 class
 *
 * @package    ArticleFeedback
 * @subpackage Api
 * @author     Greg Chiasson <greg@omniti.com>
 */

/**
 * This class pulls the individual ratings/comments for the feedback page.
 *
 * @package    ArticleFeedback
 * @subpackage Api
 */
class ApiFlagFeedbackArticleFeedbackv5 extends ApiBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, '' );
	}

	/**
	 * Execute the API call: Pull the requested feedback
	 */
	public function execute() {
		$params    = $this->extractRequestParams();
		$pageId    = $params['pageid'];
		$flag      = $params['flagtype'];
		$direction = isset( $params['direction'] ) ? $params['direction'] : 'increase';
		$counts    = array( 'increment' => array(), 'decrement' => array() );
		$counters  = array( 'abuse', 'helpful', 'unhelpful' );
		$flags     = array( 'oversight', 'hide', 'delete' );
		$results   = array();
		$helpful   = null;
		$error     = null;
		$where     = array( 'af_id' => $params['feedbackid'] );

		# load feedback record, bail if we don't have one
		$record = $this->fetchRecord( $params['feedbackid'] );

		if ( $record === false || !$record->af_id ) {
			// no-op, because this is already broken
			$error = 'articlefeedbackv5-invalid-feedback-id';
		} elseif ( in_array( $params['flagtype'], $flags ) ) {
			switch( $params['flagtype'] ) {
				case 'hide':      $field = 'af_is_hidden';       break;
				case 'oversight': $field = 'af_needs_oversight'; break;
				case 'delete':    $field = 'af_is_deleted';      break;
				default:          return; # return error, ideally.
			}

			if( $direction == 'increase' ) {
				$update[] = "$field = TRUE";
			} else {
				$update[] = "$field = FALSE";
			}	
		} elseif ( in_array( $params['flagtype'], $counters ) ) {
			// Probably this doesn't need validation, since the API
			// will handle it, but if it's getting interpolated into
			// the SQL, I'm really wary not re-validating it.
			$field = 'af_' . $params['flagtype'] . '_count';

			// Add another where condition to confirm that 
			// the new flag value is at or above 0 (we use 
			// unsigned ints, so negatives cause errors.

			if( $direction == 'increase' ) {
				$update[] = "$field = $field + 1";
				// If this is already less than 0, 
				// don't do anything - it'll just 
				// throw a SQL error, so don't bother.  
				// Incrementing from 0 is still valid.
				$where[] = "$field >= 0";
			} else {
				$update[] = "$field = $field - 1";
				// If this is already 0 or less, 
				// don't decrement it, that would
				// throw an error. 
				// Decrementing from 0 is not allowed.
				$where[] = "$field > 0";
			}
		} else {
			$error = 'articlefeedbackv5-invalid-feedback-flag';
		}

		// Newly abusive record
		if ( $flag == 'abuse' && $record->af_abuse_count == 0 ) {
			$counts['increment'][] = 'abusive';
		}

		if ( $flag == 'oversight' ) {
			$counts['increment'][] = 'needsoversight';
		}
		if ( $flag == 'unoversight' ) {
			$counts['decrement'][] = 'needsoversight';
		}


		// Newly hidden record
		if ( $flag == 'hide' && $record->af_is_hidden == 0 ) {
			$counts['increment'][] = 'invisible';
			$counts['decrement'][] = 'visible';
		}
		// Unhidden record
		if ( $flag == 'unhide' ) {
			$counts['increment'][] = 'visible';
			$counts['decrement'][] = 'invisible';
		}

		// Newly deleted record
		if ( $flag == 'delete' && $record->af_is_deleted == 0 ) {
			$counts['increment'][] = 'deleted';
			$counts['decrement'][] = 'visible';
		}
		// Undeleted record
		if ( $flag == 'undelete' ) {
			$counts['increment'][] = 'visible';
			$counts['decrement'][] = 'deleted';
		}

		// Newly helpful record
		if ( $flag == 'helpful' && $record->af_helpful_count == 0 ) {
			$counts['increment'][] = 'helpful';
		}
		// Newly unhelpful record (IE, unhelpful has overtaken helpful)
		if ( $flag == 'unhelpful'
		 && ( ( $record->af_helpful_count - $record->af_unhelpful_count ) == 1 ) ) {
			$counts['decrement'][] = 'helpful';
		}

		if ( !$error ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update(
				'aft_article_feedback',
				$update,
				$where,
				__METHOD__
			);

			if( $direction == 'decrease') {
				// This is backwards to account for a users' unflagging something.
				ApiArticleFeedbackv5Utils::incrementFilterCounts( $pageId, $counts['decrement'] );
				ApiArticleFeedbackv5Utils::decrementFilterCounts( $pageId, $counts['increment'] );
			} else {
				ApiArticleFeedbackv5Utils::incrementFilterCounts( $pageId, $counts['increment'] );
				ApiArticleFeedbackv5Utils::decrementFilterCounts( $pageId, $counts['decrement'] );
			}

			// Update helpful/unhelpful count after submission.
			// This gets a potentially stale copy from the read
			// database and assumes it's valid, in the interest
			// of staying off of the write database.
			// Better stale data than wail on the master, IMO,
			// but I'm open to suggestion on that one.
			if ( $params['flagtype'] == 'helpful' || $params['flagtype'] == 'unhelpful' ) {
				$record = $this->fetchRecord( $params['feedbackid'] );

				$helpful   = $record->af_helpful_count;
				$unhelpful = $record->af_unhelpful_count;

				$results['helpful'] = wfMessage( 'articlefeedbackv5-form-helpful-votes',
					$helpful, $unhelpful
				)->escaped();
			}

			// Conditional formatting for abuse flag
			global $wgArticleFeedbackv5AbusiveThreshold,
				$wgArticleFeedbackv5HideAbuseThreshold;
			// Re-fetch record - as above, from read/slave DB.
			// The record could have had it's falg increased or
			// decreased, so load a fresh (as fresh as the read
			// db is, anyway) copy of it.
			$record =  $this->fetchRecord( $params['feedbackid'] );
			$results['abuse_count'] = $record->af_abuse_count;
			if( $record->af_abuse_count >= $wgArticleFeedbackv5AbusiveThreshold ) {
				// Return a flag in the JSON, that turns the link red.
				$results['abusive'] = 1;
			}
			if( $record->af_abuse_count >= $wgArticleFeedbackv5HideAbuseThreshold ) {
				$dbw->update(
					'aft_article_feedback',
					array( 'af_is_hidden = af_is_hidden + 1' ),
					array( 'af_id' => $params['feedbackid'] ),
					__METHOD__
				);
				// Return a flag in the JSON, that knows to kill the row
				$results['abuse-hidden'] = 1;
			}
		}

		if ( $error ) {
			$results['result'] = 'Error';
			$results['reason'] = $error;
		} else {
			$results['result'] = 'Success';
			$results['reason'] = null;
		}

		$this->getResult()->addValue(
			null,
			$this->getModuleName(),
			$results
		);
	}

	private function fetchRecord( $id ) {
		$dbr    = wfGetDB( DB_SLAVE );
		$record = $dbr->selectRow(
			'aft_article_feedback',
			array( 'af_id', 'af_abuse_count', 'af_is_hidden', 'af_helpful_count', 'af_unhelpful_count', 'af_is_deleted' ),
			array( 'af_id' => $id )
		);
		return $record;
	}

	/**
	 * Gets the allowed parameters
	 *
	 * @return array the params info, indexed by allowed key
	 */
	public function getAllowedParams() {
		return array(
			'pageid'     => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI  => false,
				ApiBase::PARAM_TYPE     => 'integer'
			),
			'feedbackid' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI  => false,
				ApiBase::PARAM_TYPE     => 'integer'
			),
			'flagtype'   => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI  => false,
				ApiBase::PARAM_TYPE     => array(
				 'abuse', 'hide', 'helpful', 'unhelpful', 'delete', 'undelete', 'unhide', 'oversight', 'unoversight' )
			),
			'direction' => array(
				ApiBase::PARAM_REQUIRED => false,
				ApiBase::PARAM_ISMULTI  => false,
				ApiBase::PARAM_TYPE     => array(
				 'increase', 'decrease' )
			)
		);
	}

	/**
	 * Gets the parameter descriptions
	 *
	 * @return array the descriptions, indexed by allowed key
	 */
	public function getParamDescription() {
		return array(
			'feedbackid'  => 'FeedbackID to flag',
			'type'        => 'Type of flag to apply - hide or abuse'
		);
	}

	/**
	 * Gets the api descriptions
	 *
	 * @return array the description as the first element in an array
	 */
	public function getDescription() {
		return array(
			'Flag a feedbackID as abusive or hidden.'
		);
	}

	/**
	 * Gets any possible errors
	 *
	 * @return array the errors
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
				array( 'missingparam', 'anontoken' ),
				array( 'code' => 'invalidtoken', 'info' => 'The anontoken is not 32 characters' ),
			)
		);
	}

	/**
	 * Gets an example
	 *
	 * @return array the example as the first element in an array
	 */
	protected function getExamples() {
		return array(
			'api.php?list=articlefeedbackv5-view-feedback&affeedbackid=1&aftype=abuse',
		);
	}

	/**
	 * Gets the version info
	 *
	 * @return string the SVN version info
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	public function isWriteMode() { return true; }
	public function mustBePosted() { return true; }
}
