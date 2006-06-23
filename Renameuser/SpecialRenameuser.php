<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to rename users, runnable by users with renameuser
 * righs
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgAvailableRights[] = 'renameuser';
$wgGroupPermissions['bureaucrat']['renameuser'] = true;

$wgExtensionFunctions[] = 'wfSpecialRenameuser';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Renameuser',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'url' => 'http://meta.wikimedia.org/wiki/Renameuser'
);
/**
 * The maximum number of edits a user can have and still be allowed renaming,
 * set it to 0 to disable the limit.
 */
//define( 'RENAMEUSER_CONTRIBLIMIT', 6800 );
define( 'RENAMEUSER_CONTRIBLIMIT', 20000 );

function wfSpecialRenameuser() {
	global $IP, $wgMessageCache, $wgHooks;
	
	$wgMessageCache->addMessages(
		array(
			'renameuser' => 'Rename user',
			'renameuserold' => 'Current username: ',
			'renameusernew' => 'New username: ',
			'renameusersubmit' => 'Submit',
			
			'renameusererrordoesnotexist' => 'The user "<nowiki>$1</nowiki>" does not exist',
			'renameusererrorexists' => 'The user "<nowiki>$1</nowiki>" already exits',
			'renameusererrorinvalid' => 'The username "<nowiki>$1</nowiki>" is invalid',
			'renameusererrortoomany' => 'The user "<nowiki>$1</nowiki>" has $2 contributions, renaming a user with more ' .
							'than $3 contributions could adversely affect site performance',
			'renameusersuccess' => 'The user "<nowiki>$1</nowiki>" has been renamed to "<nowiki>$2</nowiki>"',
			
			'renameuserlogpage' => 'User rename log',
			'renameuserlogpagetext' => 'This is a log of changes to user names',
			'renameuserlogentry' => '',
			'renameuserlog' => 'Renamed the user "[[User:$1|$1]]" (which had $3 edits) to "[[User:$2|$2]]"',
		)
	);

	# Add a new log type
	global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
	$wgLogTypes[]                          = 'renameuser';
	$wgLogNames['renameuser']              = 'renameuserlogpage';
	$wgLogHeaders['renameuser']            = 'renameuserlogpagetext';
	$wgLogActions['renameuser/renameuser'] = 'renameuserlogentry';

	require_once "$IP/includes/SpecialPage.php";
	class Renameuser extends SpecialPage {
		function Renameuser() {
			SpecialPage::SpecialPage('Renameuser', 'renameuser');
		}
		
		function execute() {
			global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgLang;
			global $wgVersion, $wgMaxNameChars;

			$fname = 'Renameuser::execute';

			$this->setHeaders();

			if ( !$wgUser->isAllowed( 'renameuser' ) ) {
				$wgOut->permissionRequired( 'renameuser' );
				return;
			}

			if ( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			}

			if ( version_compare( $wgVersion, '1.5beta2', '<' ) ) {
				$wgOut->versionRequired( '1.5beta2' );
				return;
			}
			
			$oldusername = Title::newFromText( $wgRequest->getText( 'oldusername' ) );
			$newusername = Title::newFromText( $wgRequest->getText( 'newusername' ) );

			$action = $wgTitle->escapeLocalUrl();
			$renameuserold = wfMsgHtml( 'renameuserold' );
			$renameusernew = wfMsgHtml( 'renameusernew' );
			$oun = is_object( $oldusername ) ? $oldusername->getText() : '';
			$nun = is_object( $newusername ) ? $newusername->getText() : '';
			$submit = wfMsgHtml( 'renameusersubmit' );
			$token = $wgUser->editToken();

			$wgOut->addHTML( "
<!-- Current contributions limit is " . RENAMEUSER_CONTRIBLIMIT . " -->
<form id='renameuser' method='post' action=\"$action\">
	<table>
		<tr>
			<td align='right'>$renameuserold</td>
			<td align='left'><input tabindex='1' type='text' size='20' name='oldusername' value=\"$oun\" /></td>
		</tr>
		<tr>
			<td align='right'>$renameusernew</td>
			<td align='left'><input tabindex='1' type='text' size='20' name='newusername' value=\"$nun\"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align='right'><input type='submit' name='submit' value=\"$submit\" /></td>
		</tr>
	</table>
	<input type='hidden' name='token' value='$token' />
</form>");
			// Sanity checks
			if ( !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) 
				return;

			if ( !is_object( $oldusername ) || !is_object( $newusername ) || $oldusername->getText() == $newusername->getText() )
				return;
			
			$wgOut->addHTML( '<hr />' );
			
			// Supress username validation of old username
			$olduser = User::newFromName( $oldusername->getText(), false );
			$newuser = User::newFromName( $newusername->getText() );

			// It won't be an object if for instance "|" is supplied as a value
			if ( !is_object( $olduser ) ) {
				$wgOut->addWikiText( wfMsg( 'renameusererrorinvalid', $oldusername->getText() ) );
				return;
			}

			if ( !is_object( $newuser ) ) {
				$wgOut->addWikiText( wfMsg( 'renameusererrorinvalid', $newusername->getText() ) );
				return;
			}
			
			$uid = $olduser->idForName();
			if ($uid == 0) {
				$wgOut->addWikiText( wfMsg( 'renameusererrordoesnotexist', $oldusername->getText() ) );
				return;
			}
			
			if ($newuser->idForName() != 0) {
				$wgOut->addWikiText( wfMsg( 'renameusererrorexists', $newusername->getText() ) );
				return;
			}

			// Check edit count
			if ( !$wgUser->isAllowed( 'siteadmin' ) ) {
				$contribs = User::edits( $uid );
				if ( RENAMEUSER_CONTRIBLIMIT != 0 && $contribs > RENAMEUSER_CONTRIBLIMIT ) {
					$wgOut->addWikiText(
						wfMsg( 'renameusererrortoomany',
							$oldusername->getText(),
							$wgLang->formatNum( $contribs ),
							$wgLang->formatNum( RENAMEUSER_CONTRIBLIMIT )
						)
					);
					return;
				}
			}

			$rename = new RenameuserSQL( $oldusername->getText(), $newusername->getText(), $uid );
			$rename->rename();
			
			$log = new LogPage( 'renameuser' );
			$log->addEntry( 'renameuser', $wgTitle, wfMsg( 'renameuserlog', $oldusername->getText(), $newusername->getText(), $contribs ) );
			
			$wgOut->addWikiText( wfMsg( 'renameusersuccess', $oldusername->getText(), $newusername->getText() ) );
		}
	}

	class RenameuserSQL {
		
		/**
		  * The old username
		  *
		  * @var string 
		  * @access private
		  */
		var $old;
		
		/**
		  * The new username
		  *
		  * @var string
		  * @access private
		  */
		var $new;
		
		/**
		  * The user ID
		  *
		  * @var integer
		  * @access private
		  */
		var $uid;

		/**
		  * The the tables => fields to be updated
		  *
		  * @var array
		  * @access private
		  */
		var $tables;

		/**
		 * Constructor
		 *
		 * @param string $old The old username
		 * @param string $new The new username
		 */
		function RenameuserSQL($old, $new, $uid) {
			$this->old = $old;
			$this->new = $new;
			$this->uid = $uid;

			$this->tables = array(
				// 1.5 schema
				'user' => 'user_name',
				'revision' => 'rev_user_text',
				
				// Badly indexed table, can be very slow, and who cares if it's wrong
				/*'archive' => 'ar_user_text',*/
				
				'image' => 'img_user_text',
				'oldimage' => 'oi_user_text',

				// Very hot table, causes lag and deadlocks to update like this
				/*'recentchanges' => 'rc_user_text'*/
			);
		}

		/**
		 * Do the rename operation
		 */
		function rename() {
			global $wgMemc, $wgDBname;
			
			$fname = 'RenameuserSQL::rename';
			
			wfProfileIn( $fname );
			
			$dbw =& wfGetDB( DB_MASTER );

			foreach ($this->tables as $table => $field) {
				$dbw->update( $table,
					array( $field => $this->new ),
					array( $field => $this->old ),
					$fname
					#,array( $dbw->lowPriorityOption() )
				);
			}

			$dbw->update( 'user', 
				array( 'user_touched' => $dbw->timestamp() ), 
				array( 'user_name' => $this->new ),
				$fname
		  	);
			
			// Clear the user cache
			$wgMemc->delete( "$wgDBname:user:id:{$this->uid}" );

			wfProfileOut( $fname );
		}
	}
	SpecialPage::addPage( new Renameuser );
}
?>
