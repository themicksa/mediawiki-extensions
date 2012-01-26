/**
 * ArticleFeedback special page
 *
 * This file handles the display of feedback responses and moderation tools for
 * privileged users.  The flow goes like this:
 *
 * User arrives at special page -> basic markup is created without data -> ajax
 * request is sent to pull most recent feedback
 *
 * For each change to the selected filter or sort method, or when more feedback
 * is requested, another ajax request is sent.
 *
 * This file is long, so it's commented with manual fold markers.  To use folds
 * this way in vim:
 *   set foldmethod=marker
 *   set foldlevel=0
 *   set foldcolumn=0
 *
 * @package    ArticleFeedback
 * @subpackage Resources
 * @author     Greg Chiasson <gchiasson@omniti.com>
 * @version    $Id$
 */

( function ( $ ) {

// {{{ articleFeedbackv5 definition

	// TODO: jam sort/filter options into URL anchors, and use them as defaults if present.

	$.articleFeedbackv5special = {};

	// {{{ Properties

	/**
	 * What page is this?
	 */
	$.articleFeedbackv5special.page = undefined;

	/**
	 * The name of the filter used to select feedback
	 */
	$.articleFeedbackv5special.filter = 'comment';

	/**
	 * Some fitlers have values they need tobe passed (eg, permalinks)
	 */
	$.articleFeedbackv5special.filterValue = undefined;

	/**
	 * The name of the sorting method used
	 */
	$.articleFeedbackv5special.sort = 'age';

	/**
	 * The dorection of the sorting method used
	 */
	$.articleFeedbackv5special.sortDirection = 'desc';

	/**
	 * The number of responses to display per data pull
	 */
	$.articleFeedbackv5special.limit = 25;

	/**
	 * The index at which to start the pull
	 */
	$.articleFeedbackv5special.continue = null;

	/**
	 * The url to which to send the request
	 */
	$.articleFeedbackv5special.apiUrl = undefined;

	// }}}
	// {{{ Init methods

	// {{{ setup

	/**
	 * Sets up the page
	 */
	$.articleFeedbackv5special.setup = function() {
		// Set up config vars, event binds, and do initial fetch.
		aft5_debug( mw );
		aft5_debug( mw.util );
		$.articleFeedbackv5special.apiUrl = mw.util.wikiScript( 'api' );
		$.articleFeedbackv5special.page = mw.config.get( 'afPageId' );
		$.articleFeedbackv5special.setBinds();

		// Process anything we found in the URL hash
		// Permalinks.
		var id = window.location.hash.match(/id=(\d+)/)
		if( id ) {
			$.articleFeedbackv5special.filter      = 'id';
			$.articleFeedbackv5special.filterValue = id[1];
		}

		// Initial load
		$.articleFeedbackv5special.loadFeedback( true );
	};

	// }}}
	// {{{ setBinds

	/**
	 * Binds events for each of the controls
	 */
	$.articleFeedbackv5special.setBinds = function() {
		$( '#articleFeedbackv5-filter-select' ).bind( 'change', function( e ) {
			$.articleFeedbackv5special.filter   = $(this).val();
			$.articleFeedbackv5special.continue = null;
			$.articleFeedbackv5special.loadFeedback( true );
			return false;
		} );

		$( '.articleFeedbackv5-sort-link' ).bind( 'click', function( e ) {
			id     = $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-special-sort-' );
			oldId  = $.articleFeedbackv5special.sort;

			// set direction = desc...
			$.articleFeedbackv5special.sort     = id;
			$.articleFeedbackv5special.continue = null;

			// unless we're flipping the direction on the current sort.
			if( id == oldId && $.articleFeedbackv5special.sortDirection == 'desc' ) {
				$.articleFeedbackv5special.sortDirection = 'asc';
			}  else {
				$.articleFeedbackv5special.sortDirection = 'desc';
			}

			$.articleFeedbackv5special.loadFeedback( true );
			// draw arrow and load feedback posts
			$.articleFeedbackv5special.drawSortArrow();

			return false;
		} );

		$( '#articleFeedbackv5-show-more' ).bind( 'click', function( e ) {
			$.articleFeedbackv5special.loadFeedback( false );
			return false;
		} );

		$( '.articleFeedbackv5-permalink' ).live( 'click', function( e ) {
			id = $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-permalink-' );
			$.articleFeedbackv5special.filter      = 'id';
			$.articleFeedbackv5special.filterValue = id;
			$.articleFeedbackv5special.continue = null;
			$.articleFeedbackv5special.loadFeedback( true );
		} );

		$( '.articleFeedbackv5-comment-toggle' ).live( 'click', function( e ) {
			$.articleFeedbackv5special.toggleComment( $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-comment-toggle-' ) );
			return false;
		} );

		// Helpful and unhelpful have their own special logic, so break those out.
		$.each( ['helpful', 'unhelpful' ], function ( index, value ) { 
			$( '.articleFeedbackv5-' + value + '-link' ).live( 'click', function( e ) {
				id = $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-' + value + '-link-' );
				$.articleFeedbackv5special.flagFeedback( id, value );
				// add highlighted class
				$( this ).addClass( 'helpful-active' );
			} )
		} );

		$.each( ['unhide', 'undelete', 'oversight', 'hide', 'abuse', 'delete', 'unoversight'], function ( index, value ) { 
			$( '.articleFeedbackv5-' + value + '-link' ).live( 'click', function( e ) {
				$.articleFeedbackv5special.flagFeedback( $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-' + value + '-link-' ), value );
			} )
		} );
	}

	// }}}

	// }}}
	// {{{ Utility methods



	// {{{ toggleComment
	$.articleFeedbackv5special.toggleComment = function( id ) { 
		if( $( '#articleFeedbackv5-comment-toggle-' + id ).text() 
		 == mw.msg( 'articlefeedbackv5-comment-more' ) ) {
			$( '#articleFeedbackv5-comment-short-' + id ).hide();
			$( '#articleFeedbackv5-comment-full-' + id ).show();
			$( '#articleFeedbackv5-comment-toggle-' + id ).text(
				mw.msg( 'articlefeedbackv5-comment-less' )
			);
		} else {
			$( '#articleFeedbackv5-comment-short-' + id ).show();
			$( '#articleFeedbackv5-comment-full-' + id ).hide();
			$( '#articleFeedbackv5-comment-toggle-' + id ).text(
				mw.msg( 'articlefeedbackv5-comment-more' )
			);
		}
	}
	// }}}

	// {{{ drawSortArrow

	$.articleFeedbackv5special.drawSortArrow = function() { 
		id  = $.articleFeedbackv5special.sort;
		dir = $.articleFeedbackv5special.sortDirection;

		$( '.articleFeedbackv5-sort-arrow' ).hide();
		$( '.articleFeedbackv5-sort-link' ).removeClass( 'sort-active' );

		$( '#articleFeedbackv5-sort-arrow-' + id ).show();
		$( '#articleFeedbackv5-sort-arrow-' + id ).attr(
			'src', '/extensions/ArticleFeedbackv5/modules/jquery.articleFeedbackv5/images/sort-' + dir + 'ending.png'
		);
		$( '#articleFeedbackv5-special-sort-' + id).addClass( 'sort-active' );
	}

	// }}}
	// {{{ stripID

	// Utility method for stripping long IDs down to the specific bits we care about.
	$.articleFeedbackv5special.stripID = function( object, toRemove ) {
		return $( object ).attr( 'id' ).replace( toRemove, '' );
	}

	// }}}

	// }}}
	// {{{ Process methods

	// {{{ flagFeedback

	/**
	 * Sends the request to mark a response
	 *
	 * @param id   int    the feedback id
	 * @param type string the type of mark (valid values: hide, abuse, delete, helpful, unhelpful
	 */
	$.articleFeedbackv5special.flagFeedback = function ( id, type ) {
		$.ajax( {
			'url'     : $.articleFeedbackv5special.apiUrl,
			'type'    : 'POST',
			'dataType': 'json',
			'data'    : {
				'pageid'    : $.articleFeedbackv5special.page,
				'feedbackid': id,
				'flagtype'  : type,
				'format'    : 'json',
				'action'    : 'articlefeedbackv5-flag-feedback'
			},
			'success': function ( data ) {
				var msg = 'articlefeedbackv5-error-flagging';
				if ( 'articlefeedbackv5-flag-feedback' in data ) {
					if ( 'result' in data['articlefeedbackv5-flag-feedback'] ) {
						if( data['articlefeedbackv5-flag-feedback'].result == 'Success' ) {
							msg = 'articlefeedbackv5-' + type + '-saved';
							if( 'helpful' in data['articlefeedbackv5-flag-feedback'] ) {

								$( '#articleFeedbackv5-helpful-votes-' + id ).text( data['articlefeedbackv5-flag-feedback'].helpful );

							}
						} else if (data['articlefeedbackv5-flag-feedback'].result == 'Error' ) {
							msg = data['articlefeedbackv5-flag-feedback'].reason;
						}
					}
				}
				$( '#articleFeedbackv5-' + type + '-link-' + id ).text( mw.msg( msg ) );
			},
			'error': function ( data ) {
				$( '#articleFeedbackv5-' + type + '-link-' + id ).text( mw.msg( 'articlefeedbackv5-error-flagging' ) );
			}
		} );
		return false;
	}

	// }}}
	// {{{ loadFeedback

	/**
	 * Pulls in a set of responses.
	 *
	 * When a next-page load is requested, it appends the new responses; on a
	 * sort or filter change, the existing responses are removed from the view
	 * and replaced.
	 *
	 * @param resetContents bool whether to remove the existing responses
	 */
	$.articleFeedbackv5special.loadFeedback = function ( resetContents ) {
		$.ajax( {
			'url'     : $.articleFeedbackv5special.apiUrl,
			'type'    : 'GET',
			'dataType': 'json',
			'data'    : {
				'afvfpageid'        : $.articleFeedbackv5special.page,
				'afvffilter'        : $.articleFeedbackv5special.filter,
				'afvffiltervalue'   : $.articleFeedbackv5special.filterValue,
				'afvfsort'          : $.articleFeedbackv5special.sort,
				'afvfsortdirection' : $.articleFeedbackv5special.sortDirection,
				'afvflimit'         : $.articleFeedbackv5special.limit,
				'afvfcontinue'      : $.articleFeedbackv5special.continue,
				'action'  : 'query',
				'format'  : 'json',
				'list'    : 'articlefeedbackv5-view-feedback',
				'maxage'  : 0
			},
			'success': function ( data ) {
				if ( 'articlefeedbackv5-view-feedback' in data ) {
					if ( resetContents ) {
						$( '#articleFeedbackv5-show-feedback' ).html( data['articlefeedbackv5-view-feedback'].feedback);
					} else {
						$( '#articleFeedbackv5-show-feedback' ).append( data['articlefeedbackv5-view-feedback'].feedback);
					}
					$( '#articleFeedbackv5-feedback-count-total' ).text( data['articlefeedbackv5-view-feedback'].count );
					$.articleFeedbackv5special.continue = data['articlefeedbackv5-view-feedback'].continue;
					// set effects on toolboxes
					$( '.articleFeedbackv5-feedback-tools > ul' ).hide();
					$( '.articleFeedbackv5-feedback-tools' ).hover( 
						function( eventObj ) {
							//alert(this);
							var id = $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-feedback-tools-' );
							$( '#articleFeedbackv5-feedback-tools-list-' + id ).slideDown( 200 );
						},
						function( eventObj ) {
							var id = $.articleFeedbackv5special.stripID( this, 'articleFeedbackv5-feedback-tools-' );
							$( '#articleFeedbackv5-feedback-tools-list-' + id ).slideUp( 200 );
						}
					);
				} else {
					$( '#articleFeedbackv5-show-feedback' ).text( mw.msg( 'articlefeedbackv5-error-loading-feedback' ) );
				}
			},
			'error': function ( data ) {
				$( '#articleFeedbackv5-show-feedback' ).text( mw.msg( 'articlefeedbackv5-error-loading-feedback' ) );
			}
		} );

		return false;
	}

	// }}}

	// }}}

// }}}

} )( jQuery );

