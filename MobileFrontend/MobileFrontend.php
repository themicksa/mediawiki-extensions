<?php
/**
 * Extension MobileFrontend — Mobile Frontend
 *
 * @file
 * @ingroup Extensions
 * @author Patrick Reilly
 * @copyright © 2011 Patrick Reilly
 * @licence GNU General Public Licence 2.0 or later
 */

// Needs to be called within MediaWiki; not standalone
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Define the extension; allows us make sure the extension is used correctly
define( 'MOBILEFRONTEND', 'MobileFrontend' );
// WURFL installation dir
define( 'WURFL_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'library' .
		DIRECTORY_SEPARATOR . 'WURFL' . DIRECTORY_SEPARATOR );
// WURFL configuration files directory
define( 'RESOURCES_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'library' .
		DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR );

require_once( WURFL_DIR . 'Application.php' );

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MobileFrontend',
	'version' => ExtMobileFrontend::VERSION,
	'author' => '[http://www.mediawiki.org/wiki/User:Preilly Preilly]',
	'descriptionmsg' => 'mobile-frontend-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MobileFrontend',
);

$cwd = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$wgExtensionMessagesFiles['MobileFrontend'] = $cwd . 'MobileFrontend.i18n.php';

// autoload extension classes

$autoloadClasses = array(
						'DeviceDetection',
						'CssDetection',
						'MobileFrontendTemplate',
						'ApplicationTemplate',
						'SearchTemplate',
						'FooterTemplate',
						'LeaveFeedbackTemplate',
						'DisableTemplate',
						'OptInTemplate',
						'OptOutTemplate',
						'ApplicationWmlTemplate',
						'ThanksNoticeTemplate',
						);

foreach ( $autoloadClasses as $class ) {
	$wgAutoloadClasses[$class] = $cwd . $class . '.php';
}

/**
 * Path to the logo used in the mobile view
 *
 * Should be 22px tall at most
 */
$wgMobileFrontendLogo = false;

$wgMobileDomain = '.m.';

/**
 * URL for script used to disable mobile site
 * (protocol, host, optional port; path portion)
 *
 * e.g., http://en.wikipedia.org/w/mobileRedirect.php
 */
$wgMobileRedirectFormAction = false;

$wgExtMobileFrontend = new ExtMobileFrontend();

$wgHooks['BeforePageDisplay'][] = array( &$wgExtMobileFrontend, 'beforePageDisplayHTML' );
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array( &$wgExtMobileFrontend, 'addMobileFooter' );
$wgHooks['TestCanonicalRedirect'][] = array( &$wgExtMobileFrontend, 'testCanonicalRedirect' );

/**
 * Make the classes, tags and ids stripped from page content configurable.
 * Each item will be stripped from the page.
 * See $itemsToRemove for more information.
 */
$wgMFRemovableClasses = array();

// Unit tests
$wgHooks['UnitTestsList'][] = 'efExtMobileFrontendUnitTests';

/**
 * @param $files array
 * @return bool
 */
function efExtMobileFrontendUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/tests/MobileFrontendTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/DeviceDetectionTest.php';
	return true;
}

class ExtMobileFrontend {
	const VERSION = '0.5.99';

	/**
	 * @var DOMDocument
	 */
	private $doc, $mainPage;
	public $contentFormat = '';
	public $WMLSectionSeperator = '***************************************************************************';

	/**
	 * @var Title
	 */
	public static $title;
	public static $messages = array();
	public static $htmlTitle;
	public static $dir;
	public static $code;
	public static $device;
	public static $headings;
	public static $mainPageUrl;
	public static $randomPageUrl;
	public static $requestedSegment;
	public static $format;
	public static $search;
	public static $callback;
	public static $useFormat;
	public static $disableImages;
	public static $enableImages;
	public static $isMainPage = false;
	public static $searchField;
	public static $disableImagesURL;
	public static $enableImagesURL;
	public static $disableMobileSiteURL;
	public static $viewNormalSiteURL;
	public static $currentURL;
	public static $displayNoticeId;
	public static $leaveFeedbackURL;
	public static $mobileRedirectFormAction;
	public static $isBetaGroupMember = false;
	public static $hideSearchBox = false;
	public static $hideLogo = false;
	public static $languageUrls;
	public static $wsLoginToken = '';
	public static $wsLoginFormAction = '';
	public static $isFilePage;

	public static $messageKeys = array(
		'mobile-frontend-show-button',
		'mobile-frontend-hide-button',
		'mobile-frontend-back-to-top-of-section',
		'mobile-frontend-regular-site',
		'mobile-frontend-perm-stop-redirect',
		'mobile-frontend-home-button',
		'mobile-frontend-random-button',
		'mobile-frontend-are-you-sure',
		'mobile-frontend-explain-disable',
		'mobile-frontend-disable-button',
		'mobile-frontend-back-button',
		'mobile-frontend-opt-in-message',
		'mobile-frontend-opt-in-yes-button',
		'mobile-frontend-opt-in-no-button',
		'mobile-frontend-opt-in-title',
		'mobile-frontend-opt-out-message',
		'mobile-frontend-opt-out-yes-button',
		'mobile-frontend-opt-out-no-button',
		'mobile-frontend-opt-out-title',
		'mobile-frontend-opt-in-explain',
		'mobile-frontend-opt-out-explain',
		'mobile-frontend-disable-images',
		'mobile-frontend-wml-continue',
		'mobile-frontend-wml-back',
		'mobile-frontend-enable-images',
		'mobile-frontend-featured-article',
		'mobile-frontend-news-items',
		'mobile-frontend-leave-feedback-title',
		'mobile-frontend-leave-feedback-notice',
		'mobile-frontend-leave-feedback-subject',
		'mobile-frontend-leave-feedback-message',
		'mobile-frontend-leave-feedback-cancel',
		'mobile-frontend-leave-feedback-submit',
		'mobile-frontend-leave-feedback-link-text',
		'mobile-frontend-leave-feedback',
		'mobile-frontend-feedback-page',
		'mobile-frontend-leave-feedback-thanks',
		'mobile-frontend-search-submit',
		'mobile-frontend-language',
		'mobile-frontend-username',
		'mobile-frontend-password',
		'mobile-frontend-login',
		'mobile-frontend-placeholder',
	);

	public $itemsToRemove = array(
		'#contentSub',
		'div.messagebox',
		'#siteNotice',
		'#siteSub',
		'#jump-to-nav',
		'div.editsection',
		'div.infobox',
		'table.toc',
		'#catlinks',
		'div.stub',
		'form',
		'div.sister-project',
		'script',
		'div.magnify',
		'.editsection',
		'span.t',
		'sup[style*="help"]',
		'.portal',
		'#protected-icon',
		'.printfooter',
		'.boilerplate',
		'#id-articulo-destacado',
		'#coordinates',
		'#top',
		'.hiddenStructure',
		'.noprint',
		'.medialist',
		'.mw-search-createlink',
		'#ogg_player_1',
		'.nomobile',
	);

	/**
	 * @param $request WebRequest
	 * @param $title Title
	 * @param $output OutputPage
	 * @return bool
	 * @throws HttpError
	 */
	public function testCanonicalRedirect( $request, $title, $output ) {
		global $wgUsePathInfo, $wgMobileDomain;
		$xDevice = isset( $_SERVER['HTTP_X_DEVICE'] ) ? $_SERVER['HTTP_X_DEVICE'] : '';
		if ( empty( $xDevice ) ) {
			return true; // Let the redirect happen
		} else {
			if ( $title->getNamespace() == NS_SPECIAL ) {
				list( $name, $subpage ) = SpecialPage::resolveAlias( $title->getDBkey() );
				if ( $name ) {
					$title = SpecialPage::getTitleFor( $name, $subpage );
				}
			}
			$targetUrl = wfExpandUrl( $title->getFullURL(), PROTO_CURRENT );
			// Redirect to canonical url, make it a 301 to allow caching
			if ( $targetUrl == $request->getFullRequestURL() ) {
				$message = "Redirect loop detected!\n\n" .
					"This means the wiki got confused about what page was " .
					"requested; this sometimes happens when moving a wiki " .
					"to a new server or changing the server configuration.\n\n";

				if ( $wgUsePathInfo ) {
					$message .= "The wiki is trying to interpret the page " .
						"title from the URL path portion (PATH_INFO), which " .
						"sometimes fails depending on the web server. Try " .
						"setting \"\$wgUsePathInfo = false;\" in your " .
						"LocalSettings.php, or check that \$wgArticlePath " .
						"is correct.";
				} else {
					$message .= "Your web server was detected as possibly not " .
						"supporting URL path components (PATH_INFO) correctly; " .
						"check your LocalSettings.php for a customized " .
						"\$wgArticlePath setting and/or toggle \$wgUsePathInfo " .
						"to true.";
				}
				throw new HttpError( 500, $message );
			} else {
				$parsedUrl = wfParseUrl( $targetUrl );
				if ( stristr( $parsedUrl['host'], $wgMobileDomain ) === false ) {
					$hostParts = explode( '.', $parsedUrl['host'] );
					$parsedUrl['host'] = $hostParts[0] . $wgMobileDomain . $hostParts[1] . '.' . $hostParts[2];
				}
				$fragmentDelimiter = ( !empty( $parsedUrl['fragment'] ) ) ? '#' : '';
				$queryDelimiter = ( !empty( $parsedUrl['query'] ) ) ? '?' : '';
				$targetUrl = $parsedUrl['scheme'] . '://' .	 $parsedUrl['host'] . $parsedUrl['path']
						. $queryDelimiter . $parsedUrl['query'] . $fragmentDelimiter . $parsedUrl['fragment'];
				$output->setSquidMaxage( 1200 );
				$output->redirect( $targetUrl, '301' );
			}
			return false; // Prevent the redirect from occuring
		}
	}

	/**
	 * @param $obj Article
	 * @param $tpl
	 * @return bool
	 */
	public function addMobileFooter( &$obj, &$tpl ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$title = $obj->getTitle();
		$isSpecial = $title->isSpecialPage();

		if ( ! $isSpecial ) {
			$footerlinks = $tpl->data['footerlinks'];
			$mobileViewUrl = $wgRequest->escapeAppendQuery( 'useformat=mobile' );

			$tpl->set( 'mobileview', "<a href='{$mobileViewUrl}'>" . wfMsg( 'mobile-frontend-view' ) . "</a>" );
			$footerlinks['places'][] = 'mobileview';
			$tpl->set( 'footerlinks', $footerlinks );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $url string
	 * @param $field string
	 * @return string
	 */
	private function removeQueryStringParameter( $url, $field ) {
		wfProfileIn( __METHOD__ );
		$url = preg_replace( '/(.*)(\?|&)' . $field . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&' );
		$url = substr( $url, 0, -1 );
		wfProfileOut( __METHOD__ );
		return $url;
	}

	public function getMsg() {
		global $wgUser, $wgContLang, $wgRequest, $wgServer, $wgMobileRedirectFormAction, $wgMobileDomain, $wgOut, $wgLanguageCode;
		wfProfileIn( __METHOD__ );

		self::$disableImagesURL = $wgRequest->escapeAppendQuery( 'disableImages=1' );
		self::$enableImagesURL = $wgRequest->escapeAppendQuery( 'enableImages=1' );
		self::$disableMobileSiteURL = $wgRequest->escapeAppendQuery( 'mobileaction=disable_mobile_site' );
		self::$viewNormalSiteURL = $wgRequest->escapeAppendQuery( 'mobileaction=view_normal_site' );
		self::$currentURL = $wgRequest->getFullRequestURL();
		self::$leaveFeedbackURL = $wgRequest->escapeAppendQuery( 'mobileaction=leave_feedback' );

		$skin = $wgUser->getSkin();
		$copyright = $skin->getCopyright();
		if ( stristr( $copyright, '<li class="noprint">' ) !== false ) {
			$copyright = '<ul id="footer-info"><li>' . $copyright . '</li></ul>';
		}

		// Need to stash the results of the "wfMsg" call before the Output Buffering handler
		// because at this point the database connection is shut down, etc.

		self::$messages['mobile-frontend-copyright'] = $copyright;

		foreach ( self::$messageKeys as $messageKey ) {

			if ( $messageKey == 'mobile-frontend-leave-feedback-notice' ) {
				$linkText = wfMsg( 'mobile-frontend-leave-feedback-link-text' );
				$linkTarget = wfMsgNoTrans( 'mobile-frontend-feedback-page' );
				self::$messages[$messageKey] = wfMsgExt( $messageKey, array( 'replaceafter' ), Html::element( 'a', array( 'href' => Title::newFromText( $linkTarget )->getFullURL(), 'target' => '_blank' ), $linkText ) );
			} elseif ( $messageKey == 'mobile-frontend-feedback-page' ) {
				self::$messages[$messageKey] = wfMsgNoTrans( $messageKey );
			} else {
				self::$messages[$messageKey] = wfMsg( $messageKey );
			}
		}

		self::$dir = $wgContLang->getDir();
		self::$code = $wgContLang->getCode();

		$languageUrls = array();

		$languageUrls[] = array(
			'href' => self::$currentURL,
			'text' => self::$htmlTitle,
			'language' => $wgContLang->getLanguageName( $wgLanguageCode ),
			'class' => 'interwiki-' . $wgLanguageCode,
			'lang' => $wgLanguageCode,
		);

		foreach( $wgOut->getLanguageLinks() as $l ) {
			$tmp = explode( ':', $l, 2 );
			$class = 'interwiki-' . $tmp[0];
			$lang = $tmp[0];
			unset( $tmp );
			$nt = Title::newFromText( $l );
			if ( $nt ) {
				$parsedUrl = wfParseUrl( $nt->getFullURL() );
				if ( stristr( $parsedUrl['host'], $wgMobileDomain ) === false ) {
					$hostParts = explode( '.', $parsedUrl['host'] );
					$parsedUrl['host'] = $hostParts[0] . $wgMobileDomain . $hostParts[1] . '.' .  $hostParts[2];
				}
				$fragmentDelimiter = ( isset( $parsedUrl['fragment'] ) && $parsedUrl['fragment'] !== null  ) ? '#' : '';
				$queryDelimiter = ( isset( $parsedUrl['query'] ) && $parsedUrl['query'] !== null  ) ? '?' : '';

				$languageUrl = $parsedUrl['scheme'] . $parsedUrl['delimiter'] .	 $parsedUrl['host'] . $parsedUrl['path'];
				if ( isset( $parsedUrl['query'] ) ) {
					$languageUrl .= $queryDelimiter . $parsedUrl['query'] . $fragmentDelimiter . $parsedUrl['fragment'];
				}

				$languageUrls[] = array(
					'href' => $languageUrl,
					'text' => ( $wgContLang->getLanguageName( $nt->getInterwiki() ) != ''
							? $wgContLang->getLanguageName( $nt->getInterwiki() )
							: $l ),
					'language' => $wgContLang->getLanguageName( $lang ),
					'class' => $class,
					'lang' => $lang,
				);
			}
		}

		self::$languageUrls = $languageUrls;

		$nonMobileServerBaseURL = str_replace( $wgMobileDomain, '.', $wgServer );
		self::$mobileRedirectFormAction = ( $wgMobileRedirectFormAction !== false )
				? $wgMobileRedirectFormAction
				: "{$nonMobileServerBaseURL}/w/mobileRedirect.php";

		self::$mainPageUrl = Title::newMainPage()->getLocalUrl();
		self::$randomPageUrl = $this->getRelativeURL( SpecialPage::getTitleFor( 'Randompage' )->getLocalUrl() );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $out Outputpage
	 * @param $text String
	 * @return bool
	 */
	public function beforePageDisplayHTML( &$out, &$text ) {
		global $wgContLang, $wgRequest, $wgMemc, $wgUser;
		wfProfileIn( __METHOD__ );

		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$uAmd5 = md5( $userAgent );

		$key = wfMemcKey( 'mobile', 'ua', $uAmd5 );

		$props = null;
		try {
			$props = $wgMemc->get( $key );
			if ( !$props ) {
				$wurflConfigFile = RESOURCES_DIR . 'wurfl-config.xml';
				$wurflConfig = new WURFL_Configuration_XmlConfig( $wurflConfigFile );
				$wurflManagerFactory = new WURFL_WURFLManagerFactory( $wurflConfig );
				$wurflManager = $wurflManagerFactory->create();
				$device = $wurflManager->getDeviceForHttpRequest( $_SERVER );

				if ( $device->isSpecific() === true ) {
					$props = $device->getAllCapabilities();
					$wgMemc->set( $key, $props, 86400 );
				} else {
					$wgMemc->set( $key, 'generic', 86400 );
					$props = 'generic';
				}
			}
		} catch ( Exception $e ) {
			// echo $e->getMessage();
		}

		// Note: The WebRequest Class calls are made in this block because
		// since PHP 5.1.x, all objects have their destructors called
		// before the output buffer callback function executes.
		// Thus, globalized objects will not be available as expected in the function.
		// This is stated to be intended behavior, as per the following: [http://bugs.php.net/bug.php?id=40104]

		$xDevice = isset( $_SERVER['HTTP_X_DEVICE'] ) ? $_SERVER['HTTP_X_DEVICE'] : '';
		self::$useFormat = $wgRequest->getText( 'useformat' );
		$mobileAction = $wgRequest->getText( 'mobileaction' );
		$action = $wgRequest->getText( 'action' );

		if ( self::$useFormat === 'mobile' || self::$useFormat === 'mobile-wap' ||
			$xDevice ) {
				if ( $action !== 'edit' &&
					 $mobileAction !== 'view_normal_site' ) {

					self::$title = $out->getTitle();

					if (  Title::newMainPage()->equals( self::$title ) ) {
						self::$isMainPage = true;
					}
					if ( self::$title->getNamespace() == NS_FILE ) {
						self::$isFilePage = true;
					}

					self::$htmlTitle = $out->getHTMLTitle();
					self::$disableImages = $wgRequest->getText( 'disableImages', 0 );
					self::$enableImages = $wgRequest->getText( 'enableImages', 0 );
					self::$displayNoticeId = $wgRequest->getText( 'noticeid', '' );

					if ( self::$disableImages == 1 ) {
						$wgRequest->response()->setcookie( 'disableImages', 1 );
						$location = str_replace( '?disableImages=1', '', str_replace( '&disableImages=1', '', $wgRequest->getFullRequestURL() ) );
						$location = str_replace( '&mfi=1', '', str_replace( '&mfi=0', '', $location ) );
						$location = $this->getRelativeURL( $location );
						$wgRequest->response()->header( 'Location: ' . $location . '&mfi=0' );
					}

					if ( self::$disableImages == 0 ) {
						$disableImages = $wgRequest->getCookie( 'disableImages' );
						if ( $disableImages ) {
							self::$disableImages = $disableImages;
						}
					}

					if ( self::$enableImages == 1 ) {
						$disableImages = $wgRequest->getCookie( 'disableImages' );
						if ( $disableImages ) {
							$wgRequest->response()->setcookie( 'disableImages', '' );
						}
						$location = str_replace( '?enableImages=1', '', str_replace( '&enableImages=1', '', $wgRequest->getFullRequestURL() ) );
						$location = str_replace( '&mfi=1', '', str_replace( '&mfi=0', '', $location ) );
						$location = $this->getRelativeURL( $location );
						$wgRequest->response()->header( 'Location: ' . $location . '&mfi=1' );
					}

					self::$format = $wgRequest->getText( 'format' );
					self::$callback = $wgRequest->getText( 'callback' );
					self::$requestedSegment = $wgRequest->getText( 'seg', 0 );
					self::$search = $wgRequest->getText( 'search' );
					self::$searchField = $wgRequest->getText( 'search', '' );

					$acceptHeader = isset( $_SERVER["HTTP_ACCEPT"] ) ? $_SERVER["HTTP_ACCEPT"] : '';
					$device = new DeviceDetection();

					if ( $xDevice ) {
						$formatName = $xDevice;
					} else {
						$formatName = $device->formatName( $userAgent, $acceptHeader );
					}

					self::$device = $device->format( $formatName );

					if ( self::$device['view_format'] === 'wml' ) {
						$this->contentFormat = 'WML';
					} elseif ( self::$device['view_format'] === 'html' ) {
						$this->contentFormat = 'XHTML';
					}

					if ( self::$useFormat === 'mobile-wap' ) {
						$this->contentFormat = 'WML';
					}

					if ( $mobileAction == 'leave_feedback' ) {
						echo $this->renderLeaveFeedbackXHTML();
						wfProfileOut( __METHOD__ );
						exit();
					}

					if ( $mobileAction == 'leave_feedback_post' ) {

						$this->getMsg();

						$subject = $wgRequest->getText( 'subject', '' );
						$message = $wgRequest->getText( 'message', '' );
						$token = $wgRequest->getText( 'edittoken', '' );

						$title = Title::newFromText( self::$messages['mobile-frontend-feedback-page'] );

						if ( $title->userCan( 'edit' ) &&
							!$wgUser->isBlockedFrom( $title ) &&
							$wgUser->matchEditToken( $token ) ) {
							$article = new Article( $title, 0 );
							$rawtext = $article->getRawText();
							$rawtext .= "\n== {$subject} == \n {$message} ~~~~ \n <small>User agent: {$userAgent}</small> ";
							$article->doEdit( $rawtext, '' );
						}

						$location = str_replace( '&mobileaction=leave_feedback_post', '', $wgRequest->getFullRequestURL() . '&noticeid=1&useformat=mobile' );
						$location = $this->getRelativeURL( $location );
						$wgRequest->response()->header( 'Location: ' . $location );
						wfProfileOut( __METHOD__ );
						exit();
					}

					if ( $mobileAction == 'disable_mobile_site' && $this->contentFormat == 'XHTML' ) {
						echo $this->renderDisableMobileSiteXHTML();
						wfProfileOut( __METHOD__ );
						exit();
					}

					if ( $mobileAction == 'opt_in_mobile_site' && $this->contentFormat == 'XHTML' ) {
						echo $this->renderOptInMobileSiteXHTML();
						wfProfileOut( __METHOD__ );
						exit();
					}

					if ( $mobileAction == 'opt_out_mobile_site' && $this->contentFormat == 'XHTML' ) {
						echo $this->renderOptOutMobileSiteXHTML();
						wfProfileOut( __METHOD__ );
						exit();
					}

					if ( $mobileAction == 'opt_in_cookie' ) {
						wfIncrStats( 'mobile.opt_in_cookie_set' );
						$this->setOptInOutCookie( '1' );
						$this->disableCaching();
						$location = wfExpandUrl( Title::newMainPage()->getFullURL(), PROTO_CURRENT );
						$wgRequest->response()->header( 'Location: ' . $location );
					}

					if ( $mobileAction == 'opt_out_cookie' ) {
						$this->setOptInOutCookie( '' );
					}

					$this->getMsg();
					$this->disableCaching();
					$this->sendXDeviceVaryHeader();
					$this->sendApplicationVersionVaryHeader();
					$this->checkUserStatus();
					$this->checkUserLoggedIn();

					if ( self::$title->isSpecial( 'Userlogin' ) && self::$isBetaGroupMember ) {
						self::$wsLoginToken = $wgRequest->getSessionData( 'wsLoginToken' );
						$q = array( 'action' => 'submitlogin', 'type' => 'login' );
						$returnToVal = $wgRequest->getVal( 'returnto' );

						if ( $returnToVal ) {
							$q['returnto'] = $returnToVal;
						}

						self::$wsLoginFormAction = self::$title->getLocalURL( $q );
					}

					$this->setDefaultLogo();
					ob_start( array( $this, 'DOMParse' ) );
				}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @return bool
	 */
	private function checkUserLoggedIn() {
		global $wgUser, $wgCookieDomain, $wgRequest, $wgCookiePrefix;
		wfProfileIn( __METHOD__ );
		$tempWgCookieDomain = $wgCookieDomain;
		$wgCookieDomain = $this->getBaseDomain();
		$tempWgCookiePrefix = $wgCookiePrefix;
		$wgCookiePrefix = '';

		if ( $wgUser->isLoggedIn() ) {
			$wgRequest->response()->setcookie( 'mfsecure', '1', 0, '' );
		} else {
			$mfSecure = $wgRequest->getCookie( 'mfsecure', '' );
			if ( $mfSecure && $mfSecure == '1' ) {
				$wgRequest->response()->setcookie( 'mfsecure', '', 0, '' );
			}
		}

		$wgCookieDomain = $tempWgCookieDomain;
		$wgCookiePrefix = $tempWgCookiePrefix;
		wfProfileOut( __METHOD__ );
		return true;
	}

	private function checkUserStatus() {
		wfProfileIn( __METHOD__ );

		if ( !empty( $_SERVER['HTTP_APPLICATION_VERSION'] ) &&
			strpos( $_SERVER['HTTP_APPLICATION_VERSION'], 'Wikipedia Mobile' ) !== false ) {
			self::$hideSearchBox = true;
			if (strpos( $_SERVER['HTTP_APPLICATION_VERSION'], 'Android' ) !== false ) {
				self::$hideLogo = true;
			}
		}

		$optInCookie = $this->getOptInOutCookie();
		if ( !empty( $optInCookie ) &&
			$optInCookie == 1 ) {
			self::$isBetaGroupMember = true;
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $value string
	 */
	private function setOptInOutCookie( $value ) {
		global $wgCookieDomain, $wgRequest, $wgCookiePrefix;
		wfProfileIn( __METHOD__ );
		$tempWgCookieDomain = $wgCookieDomain;
		$wgCookieDomain = $this->getBaseDomain();
		$tempWgCookiePrefix = $wgCookiePrefix;
		$wgCookiePrefix = '';
		$wgRequest->response()->setcookie( 'optin', $value, 0, '' );
		$wgCookieDomain = $tempWgCookieDomain;
		$wgCookiePrefix = $tempWgCookiePrefix;
		wfProfileOut( __METHOD__ );
		return true;
	}

	private function getOptInOutCookie() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$optInCookie = $wgRequest->getCookie( 'optin', '' );
		wfProfileOut( __METHOD__ );
		return $optInCookie;
	}

	/**
	 * @return string
	 */
	private function getBaseDomain() {
		wfProfileIn( __METHOD__ );
		// Validates value as IP address
		if ( !IP::isValid( $_SERVER['HTTP_HOST'] ) ) {
			$domainParts = explode( '.', $_SERVER['HTTP_HOST'] );
			$domainParts = array_reverse( $domainParts );
			// Although some browsers will accept cookies without the initial ., » RFC 2109 requires it to be included.
			wfProfileOut( __METHOD__ );
			return '.' . $domainParts[1] . '.' . $domainParts[0];
		}
		wfProfileOut( __METHOD__ );
		return $_SERVER['HTTP_HOST'];
	}

	/**
	 * @param $url string
	 * @return string
	 */
	private function getRelativeURL( $url ) {
		wfProfileIn( __METHOD__ );
		$parsedUrl = parse_url( $url );
		// Validates value as IP address
		if ( !empty( $parsedUrl['host'] ) && !IP::isValid( $parsedUrl['host'] ) ) {
			$baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
			$baseUrl = str_replace( $baseUrl, '', $url );
			wfProfileOut( __METHOD__ );
			return $baseUrl;
		}
		wfProfileOut( __METHOD__ );
		return $url;
	}

	private function disableCaching() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		if ( isset( $_SERVER['HTTP_VIA'] ) &&
			stripos( $_SERVER['HTTP_VIA'], '.wikimedia.org:3128' ) !== false ) {
			$wgRequest->response()->header( 'Cache-Control: no-cache, must-revalidate' );
			$wgRequest->response()->header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
			$wgRequest->response()->header( 'Pragma: no-cache' );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	private function sendXDeviceVaryHeader() {
		global $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );
		if ( isset( $_SERVER['HTTP_X_DEVICE'] ) ) {
			$wgRequest->response()->header( 'X-Device: ' . $_SERVER['HTTP_X_DEVICE'] );
			$wgOut->addVaryHeader( 'X-Device' );
		}
		$wgOut->addVaryHeader( 'Cookie' );
		wfProfileOut( __METHOD__ );
		return true;
	}

	private function sendApplicationVersionVaryHeader() {
		global $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );
		if ( isset( $_SERVER['HTTP_APPLICATION_VERSION'] ) ) {
			$wgRequest->response()->header( 'Application_Version: ' . $_SERVER['HTTP_APPLICATION_VERSION'] );
			$wgOut->addVaryHeader( 'Application_Version' );
		} else {
			if ( isset( $_SERVER['HTTP_X_DEVICE'] ) ) {
				if ( stripos( $_SERVER['HTTP_X_DEVICE'], 'iphone' ) !== false ||
					stripos( $_SERVER['HTTP_X_DEVICE'], 'android' ) !== false ) {
					$wgRequest->response()->header( 'Application_Version: ' . $_SERVER['HTTP_X_DEVICE'] );
					$wgOut->addVaryHeader( 'Application_Version' );
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @return string
	 */
	private function renderLeaveFeedbackXHTML() {
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );
		if ( $this->contentFormat == 'XHTML' ) {
			$this->getMsg();
			$searchTemplate = $this->getSearchTemplate();
			$searchWebkitHtml = $searchTemplate->getHTML();
			$footerTemplate = $this->getFooterTemplate();
			$footerHtml = $footerTemplate->getHTML();
			$leaveFeedbackTemplate = new LeaveFeedbackTemplate();
			$options = array(
							'feedbackPostURL' => str_replace( '&mobileaction=leave_feedback', '', $wgRequest->getFullRequestURL() ) . '&mobileaction=leave_feedback_post',
							'editToken' => $wgUser->editToken(),
							'title' => self::$messages['mobile-frontend-leave-feedback-title'],
							'notice' => self::$messages['mobile-frontend-leave-feedback-notice'],
							'subject' => self::$messages['mobile-frontend-leave-feedback-subject'],
							'message' => self::$messages['mobile-frontend-leave-feedback-message'],
							'cancel' => self::$messages['mobile-frontend-leave-feedback-cancel'],
							'submit' => self::$messages['mobile-frontend-leave-feedback-submit'],
							);
			$leaveFeedbackTemplate->setByArray( $options );
			$leaveFeedbackHtml = $leaveFeedbackTemplate->getHTML();
			$contentHtml = $leaveFeedbackHtml;
			$noticeHtml = ( !empty( $noticeHtml ) ) ? $noticeHtml : '';
			$applicationTemplate = $this->getApplicationTemplate();
			$options = array(
							'noticeHtml' => $noticeHtml,
							'htmlTitle' => self::$messages['mobile-frontend-leave-feedback'];,
							'searchWebkitHtml' => $searchWebkitHtml,
							'contentHtml' => $contentHtml,
							'footerHtml' => $footerHtml,
							);
			$applicationTemplate->setByArray( $options );
			$applicationHtml = $applicationTemplate->getHTML();
			wfProfileOut( __METHOD__ );
			return $applicationHtml;
		}
		wfProfileOut( __METHOD__ );
		return '';
	}

	/**
	 * @return string
	 */
	private function renderOptInMobileSiteXHTML() {
		wfProfileIn( __METHOD__ );
		if ( $this->contentFormat == 'XHTML' ) {
			$this->getMsg();
			$searchTemplate = $this->getSearchTemplate();
			$searchWebkitHtml = $searchTemplate->getHTML();
			$footerTemplate = $this->getFooterTemplate();
			$footerHtml = $footerTemplate->getHTML();
			$optInTemplate = new OptInTemplate();
			$options = array(
							'explainOptIn' => self::$messages['mobile-frontend-opt-in-explain'],
							'optInMessage' => self::$messages['mobile-frontend-opt-in-message'],
							'yesButton' => self::$messages['mobile-frontend-opt-in-yes-button'],
							'noButton' => self::$messages['mobile-frontend-opt-in-no-button'],
							'formAction' => wfExpandUrl( Title::newMainPage()->getFullURL(), PROTO_CURRENT ),
							);
			$optInTemplate->setByArray( $options );
			$optInHtml = $optInTemplate->getHTML();
			$contentHtml = $optInHtml;
			$noticeHtml = ( !empty( $noticeHtml ) ) ? $noticeHtml : '';
			$applicationTemplate = $this->getApplicationTemplate();
			$options = array(
							'noticeHtml' => $noticeHtml,
							'htmlTitle' => self::$messages['mobile-frontend-opt-in-title'],
							'searchWebkitHtml' => $searchWebkitHtml,
							'contentHtml' => $contentHtml,
							'footerHtml' => $footerHtml,
							);
			$applicationTemplate->setByArray( $options );
			$applicationHtml = $applicationTemplate->getHTML();
			wfProfileOut( __METHOD__ );
			return $applicationHtml;
		}
		wfProfileOut( __METHOD__ );
		return '';
	}

	/**
	 * @return string
	 */
	private function renderOptOutMobileSiteXHTML() {
		wfProfileIn( __METHOD__ );
		if ( $this->contentFormat == 'XHTML' ) {
			$this->getMsg();
			$searchTemplate = $this->getSearchTemplate();
			$searchWebkitHtml = $searchTemplate->getHTML();
			$footerTemplate = $this->getFooterTemplate();
			$footerHtml = $footerTemplate->getHTML();
				$optOutTemplate = new OptOutTemplate();
				$options = array(
								'explainOptOut' => self::$messages['mobile-frontend-opt-out-explain'],
								'optOutMessage' => self::$messages['mobile-frontend-opt-out-message'],
								'yesButton' => self::$messages['mobile-frontend-opt-out-yes-button'],
								'noButton' => self::$messages['mobile-frontend-opt-out-no-button'],
								'formAction' => wfExpandUrl( Title::newMainPage()->getFullURL(), PROTO_CURRENT ),
								);
				$optOutTemplate->setByArray( $options );
				$optOutHtml = $optOutTemplate->getHTML();
			$contentHtml = $optOutHtml;
			$noticeHtml = ( !empty( $noticeHtml ) ) ? $noticeHtml : '';
			$applicationTemplate = $this->getApplicationTemplate();
			$options = array(
							'noticeHtml' => $noticeHtml,
							'htmlTitle' => self::$messages['mobile-frontend-opt-out-title'],
							'searchWebkitHtml' => $searchWebkitHtml,
							'contentHtml' => $contentHtml,
							'footerHtml' => $footerHtml,
							);
			$applicationTemplate->setByArray( $options );
			$applicationHtml = $applicationTemplate->getHTML();
			wfProfileOut( __METHOD__ );
			return $applicationHtml;
		}
		wfProfileOut( __METHOD__ );
		return '';
	}

	/**
	 * @return string
	 */
	private function renderDisableMobileSiteXHTML() {
		wfProfileIn( __METHOD__ );
		if ( $this->contentFormat == 'XHTML' ) {
			$this->getMsg();
			$areYouSure = self::$messages['mobile-frontend-are-you-sure'];
			$explainDisable = self::$messages['mobile-frontend-explain-disable'];
			$disableButton = self::$messages['mobile-frontend-disable-button'];
			$backButton = self::$messages['mobile-frontend-back-button'];
			$htmlTitle = $areYouSure;
			$title = $areYouSure;
			$searchTemplate = $this->getSearchTemplate();
			$searchWebkitHtml = $searchTemplate->getHTML();
			$footerTemplate = $this->getFooterTemplate();
			$footerHtml = $footerTemplate->getHTML();
			$disableTemplate = new DisableTemplate();
			$options = array(
							'currentURL' => self::$currentURL,
							'mobileRedirectFormAction' => self::$mobileRedirectFormAction,
							'areYouSure' => $areYouSure,
							'explainDisable' => $explainDisable,
							'disableButton' => $disableButton,
							'backButton' => $backButton,
							'htmlTitle' => $htmlTitle,
							'title' => $title,
							);
			$disableTemplate->setByArray( $options );
			$disableHtml = $disableTemplate->getHTML();
			
			$contentHtml = $disableHtml;
			$noticeHtml = ( !empty( $noticeHtml ) ) ? $noticeHtml : '';
			$applicationTemplate = $this->getApplicationTemplate();
			$options = array(
							'noticeHtml' => $noticeHtml,
							'htmlTitle' => $htmlTitle,
							'searchWebkitHtml' => $searchWebkitHtml,
							'contentHtml' => $contentHtml,
							'footerHtml' => $footerHtml,
							);
			$applicationTemplate->setByArray( $options );
			$applicationHtml = $applicationTemplate->getHTML();
			wfProfileOut( __METHOD__ );
			return $applicationHtml;
		}
		wfProfileOut( __METHOD__ );
		return '';
	}

	/**
	 * @param $matches array
	 * @return string
	 */
	private function headingTransformCallbackWML( $matches ) {
		wfProfileIn( __METHOD__ );
		static $headings = 0;
		++$headings;

		$base = $this->WMLSectionSeperator .
				"<h2 class='section_heading' id='section_{$headings}'>{$matches[2]}</h2>";

		self::$headings = $headings;
		wfProfileOut( __METHOD__ );
		return $base;
	}

	/**
	 * @param $matches array
	 * @return string
	 */
	private function headingTransformCallbackXHTML( $matches ) {
		wfProfileIn( __METHOD__ );
		if ( isset( $matches[0] ) ) {
			preg_match( '/id="([^"]*)"/', $matches[0], $headlineMatches );
		}

		$headlineId = ( isset( $headlineMatches[1] ) ) ? $headlineMatches[1] : '';

		static $headings = 0;
		$show = self::$messages['mobile-frontend-show-button'];
		$hide = self::$messages['mobile-frontend-hide-button'];
		$backToTop = self::$messages['mobile-frontend-back-to-top-of-section'];
		++$headings;
		// Back to top link
		$base = Html::openElement( 'div',
						array( 'id' => 'anchor_' . intval( $headings - 1 ),
								'class' => 'section_anchors', )
				) .
				Html::rawElement( 'a',
						array( 'href' => '#section_' . intval( $headings - 1 ),
								'class' => 'back_to_top' ),
								'&#8593;' . $backToTop ) .
				Html::closeElement( 'div' );
		// generate the HTML we are going to inject
		$buttons = Html::element( 'button',
					array( 'class' => 'section_heading show',
							'section_id' => $headings ),
							$show ) .
			Html::element( 'button',
					array( 'class' => 'section_heading hide',
							'section_id' => $headings ),
							$hide );
		if ( self::$device['supports_javascript'] ) {
			$h2OnClick = 'javascript:wm_toggle_section(' . $headings . ');';
			$base .= Html::openElement( 'h2',
							array( 'class' => 'section_heading',
									'id' => 'section_' . $headings,
									'onclick' => $h2OnClick ) );
		} else {
			$base .= Html::openElement( 'h2',
							array( 'class' => 'section_heading',
									'id' => 'section_' . $headings ) );
		}
		$base .= $buttons .
				Html::rawElement( 'span',
						array( 'id' => $headlineId ),
								$matches[2] ) .
				Html::closeElement( 'h2' ) .
				Html::openElement( 'div',
						array( 'class' => 'content_block',
								'id' => 'content_' . $headings ) );

		if ( $headings > 1 ) {
			// Close it up here
			$base = Html::closeElement( 'div' ) . $base;
		}

		self::$headings = $headings;
		wfProfileOut( __METHOD__ );
		return $base;
	}

	/**
	 * @param $s string
	 * @return string
	 */
	public function headingTransform( $s ) {
		wfProfileIn( __METHOD__ );
		$callback = 'headingTransformCallback';
		$callback .= $this->contentFormat;

		// Closures are a PHP 5.3 feature.
		// MediaWiki currently requires PHP 5.2.3 or higher.
		// So, using old style for now.
		$s = preg_replace_callback(
			'/<h2(.*)<span class="mw-headline" [^>]*>(.+)<\/span>\w*<\/h2>/',
			array( $this, $callback ),
			$s
		);

		// if we had any, make sure to close the whole thing!
		if ( isset( self::$headings ) && self::$headings > 0 ) {
			$s = str_replace(
				'<div class="visualClear">',
				'</div><div class="visualClear">',
				$s
			);
		}
		wfProfileOut( __METHOD__ );
		return $s;
	}

	/**
	 * @param $s string
	 * @return string
	 */
	private function createWMLCard( $s ) {
		wfProfileIn( __METHOD__ );
		$segments = explode( $this->WMLSectionSeperator, $s );
		$card = '';
		$idx = 0;
		$requestedSegment = htmlspecialchars( self::$requestedSegment );
		$title = htmlspecialchars( self::$title->getText() );

		$card .= "<card id='s{$idx}' title='{$title}'><p>{$segments[$requestedSegment]}</p>";
		$idx = $requestedSegment + 1;
		$segmentsCount = count( $segments );
		$card .= "<p>" . $idx . "/" . $segmentsCount . "</p>";

		$useFormatParam = ( isset( self::$useFormat ) ) ? '&amp;' . 'useformat=' . self::$useFormat : '';

		// Title::getLocalUrl doesn't work at this point since PHP 5.1.x, all objects have their destructors called
		// before the output buffer callback function executes.
		// Thus, globalized objects will not be available as expected in the function.
		// This is stated to be intended behavior, as per the following: [http://bugs.php.net/bug.php?id=40104]
		$mDefaultQuery = $_GET;
		unset( $mDefaultQuery['seg'] );
		unset( $mDefaultQuery['useformat'] );

		$qs = wfArrayToCGI( $mDefaultQuery );
		$delimiter = ( !empty( $qs ) ) ? '?' : '';
		$basePageParts = wfParseUrl( self::$currentURL );
		$basePage = $basePageParts['scheme'] . $basePageParts['delimiter'] . $basePageParts['host'] . $basePageParts['path'] . $delimiter . $qs;
		$appendDelimiter = ( $delimiter === '?' ) ? '&amp;' : '?';

		if ( $idx < $segmentsCount ) {
			$card .= "<p><a href=\"{$basePage}{$appendDelimiter}seg={$idx}{$useFormatParam}\">" . self::$messages['mobile-frontend-wml-continue'] . "</a></p>";
		}

		if ( $idx > 1 ) {
			$back_idx = $requestedSegment - 1;
			$card .= "<p><a href=\"{$basePage}{$appendDelimiter}seg={$back_idx}{$useFormatParam}\">" . self::$messages['mobile-frontend-wml-back'] . "</a></p>";
		}

		$card .= '</card>';
		wfProfileOut( __METHOD__ );
		return $card;
	}

	/**
	 * @return array
	 */
	private function parseItemsToRemove() {
		global $wgMFRemovableClasses;
		wfProfileIn( __METHOD__ );
		$itemToRemoveRecords = array();

		foreach ( array_merge( $this->itemsToRemove, $wgMFRemovableClasses ) as $itemToRemove ) {
			$type = '';
			$rawName = '';
			CssDetection::detectIdCssOrTag( $itemToRemove, $type, $rawName );
			$itemToRemoveRecords[$type][] = $rawName;
		}

		wfProfileOut( __METHOD__ );
		return $itemToRemoveRecords;
	}

	/**
	 * @param $html string
	 * @return string
	 */
	public function DOMParseMainPage( $html ) {
		wfProfileIn( __METHOD__ );
		$html = mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" );
		libxml_use_internal_errors( true );
		$this->mainPage = new DOMDocument();
		// It seems that loadhtml() does not "attach" the html dtd that defines id as an id-attribute to the DOM.
		$this->mainPage->loadHTML( '<?xml encoding="UTF-8"><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
									<html><head><title></title></head><body>' . $html . '</body></html>' );
		libxml_use_internal_errors( false );
		$this->mainPage->preserveWhiteSpace = false;
		$this->mainPage->strictErrorChecking = false;
		$this->mainPage->encoding = 'UTF-8';

		$featuredArticle = $this->mainPage->getElementById( 'mp-tfa' );
		$newsItems = $this->mainPage->getElementById( 'mp-itn' );

		$xpath = new DOMXpath( $this->mainPage );
		$elements = $xpath->query( '//*[starts-with(@id, "mf-")]' );

		$commonAttributes = array( 'mp-tfa', 'mp-itn' );

		$content = $this->mainPage->createElement( 'div' );
		$content->setAttribute( 'id', 'content' );

		if ( $featuredArticle ) {
			$h2FeaturedArticle = $this->mainPage->createElement( 'h2', self::$messages['mobile-frontend-featured-article'] );
			$content->appendChild( $h2FeaturedArticle );
			$content->appendChild( $featuredArticle );
		}

		if ( $newsItems ) {
			$h2NewsItems = $this->mainPage->createElement( 'h2', self::$messages['mobile-frontend-news-items'] );
			$content->appendChild( $h2NewsItems );
			$content->appendChild( $newsItems );
		}

		foreach ( $elements as $element ) {
			if ( $element->hasAttribute( 'id' ) ) {
				$id = $element->getAttribute( 'id' );
				if ( !in_array( $id, $commonAttributes ) ) {
					$elementTitle = $element->hasAttribute( 'title' ) ? $element->getAttribute( 'title' ) : '';
					$h2UnknownMobileSection = $this->mainPage->createElement( 'h2', $elementTitle );
					$br = $this->mainPage->createElement( 'br' );
					$br->setAttribute( 'CLEAR', 'ALL' );
					$content->appendChild( $h2UnknownMobileSection );
					$content->appendChild( $element );
					$content->appendChild( $br );
				}
			}
		}

		$contentHtml = $this->mainPage->saveXML( $content, LIBXML_NOEMPTYTAG );
		wfProfileOut( __METHOD__ );
		return $contentHtml;
	}

	/**
	 * @return DomElement
	 */
	public function renderLogin() {
		wfProfileIn( __METHOD__ );
		$form = Html::openElement( 'form',
					array( 'name' => 'userlogin',
				   		   'method' => 'post',
				   		   'action' => self::$wsLoginFormAction ) ) .
				Html::openElement( 'table',
					array( 'class' => 'user-login' ) ) .
				Html::openElement( 'tbody' ) .
				Html::openElement( 'tr' ) .
				Html::openElement( 'td',
					array( 'class' => 'mw-label' ) ) .
				Html::element( 'label',
		 			array( 'for' => 'wpName1' ), self::$messages['mobile-frontend-username'] ) .
				Html::closeElement( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::openElement( 'tr' ) .
				Html::openElement( 'td' ) .
				Html::input( 'wpName', null, 'text',
					array( 'class' => 'loginText',
						   'id' => 'wpName1',
						   'tabindex' => '1',
						   'size' => '20',
						   'required') ) .
				Html::closeElement( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::openElement( 'tr' ) .
				Html::openElement( 'td',
					array( 'class' => 'mw-label' ) ) .
				Html::element( 'label',
		 			array( 'for' => 'wpPassword1' ), self::$messages['mobile-frontend-password'] ) .
				Html::closeElement( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::openElement( 'tr' ) .
				Html::openElement( 'td',
					array( 'class' => 'mw-input' ) ) .
		 		Html::input( 'wpPassword', null, 'password',
					array( 'class' => 'loginPassword',
						   'id' => 'wpPassword1',
						   'tabindex' => '2',
						   'size' => '20') ) .
				Html::closeElement( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::openElement( 'tr' ) .
				Html::element( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::openElement( 'tr' ) .
				Html::openElement( 'td',
					array( 'class' => 'mw-submit' ) ) .
				Html::input( 'wpLoginAttempt', self::$messages['mobile-frontend-login'], 'submit',
					array( 'id' => 'wpLoginAttempt',
						   'tabindex' => '3') ) .
				Html::closeElement( 'td' ) .
				Html::closeElement( 'tr' ) .
				Html::closeElement( 'tbody' ) .
				Html::closeElement( 'table' ) .
				Html::input( 'wpLoginToken', self::$wsLoginToken, 'hidden' ) .
				Html::closeElement( 'form' );
		wfProfileOut( __METHOD__ );
		return $this->getDomDocumentNodeByTagName( $form, 'form' );
	}

	/**
	 * @param $html string
	 * @param $tagName string
	 * @return DomElement
	 */
	private function getDomDocumentNodeByTagName( $html, $tagName ) {
		wfProfileIn( __METHOD__ );
		libxml_use_internal_errors( true );
		$dom = new DOMDocument();
		$dom->loadHTML( $html );
		libxml_use_internal_errors( false );
		$dom->preserveWhiteSpace = false;
		$dom->strictErrorChecking = false;
		$dom->encoding = 'UTF-8';
		$node = $dom->getElementsByTagName( $tagName )->item(0);
		wfProfileOut( __METHOD__ );
		return $node;
	}

	/**
	 * @param $html string
	 * @return string
	 */
	public function DOMParse( $html ) {
		global $wgScript;
		wfProfileIn( __METHOD__ );
		$html = mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" );
		libxml_use_internal_errors( true );
		$this->doc = new DOMDocument();
		$this->doc->loadHTML( '<?xml encoding="UTF-8">' . $html );
		libxml_use_internal_errors( false );
		$this->doc->preserveWhiteSpace = false;
		$this->doc->strictErrorChecking = false;
		$this->doc->encoding = 'UTF-8';

		$itemToRemoveRecords = $this->parseItemsToRemove();

		$ptLogout = $this->doc->getElementById( 'pt-logout' );

		if ( $ptLogout ) {
			$ptLogoutLink = $ptLogout->firstChild;
			$logoutHtml = $this->doc->saveXML( $ptLogoutLink, LIBXML_NOEMPTYTAG );
		}

		if ( self::$title->isSpecial( 'Userlogin' ) && self::$isBetaGroupMember ) {
			$userlogin = $this->doc->getElementById( 'userloginForm' );

			if ( $userlogin && get_class( $userlogin ) === 'DOMElement' ) {
				$firstHeading = $this->doc->getElementById( 'firstHeading' );
				if ( !empty( $firstHeading ) ) {
					$firstHeading->nodeValue = '';
				}
			}
		}

		// Tags

		// You can't remove DOMNodes from a DOMNodeList as you're iterating
		// over them in a foreach loop. It will seemingly leave the internal
		// iterator on the foreach out of wack and results will be quite
		// strange. Though, making a queue of items to remove seems to work.
		// For example:

		if ( self::$disableImages == 1 ) {
			$itemToRemoveRecords['TAG'][] = "img";
			$itemToRemoveRecords['TAG'][] = "audio";
			$itemToRemoveRecords['TAG'][] = "video";
			$itemToRemoveRecords['CLASS'][] = "thumb tright";
			$itemToRemoveRecords['CLASS'][] = "thumb tleft";
			$itemToRemoveRecords['CLASS'][] = "thumbcaption";
			$itemToRemoveRecords['CLASS'][] = "gallery";
		}

		$domElemsToRemove = array();
		foreach ( $itemToRemoveRecords['TAG'] as $tagToRemove ) {
			$tagToRemoveNodes = $this->doc->getElementsByTagName( $tagToRemove );

			foreach ( $tagToRemoveNodes as $tagToRemoveNode ) {
				if ( $tagToRemoveNode ) {
					$domElemsToRemove[] = $tagToRemoveNode;
				}
			}
		}

		foreach ( $domElemsToRemove as $domElement ) {
			$domElement->parentNode->removeChild( $domElement );
		}

		// Elements with named IDs
		foreach ( $itemToRemoveRecords['ID'] as $itemToRemove ) {
			$itemToRemoveNode = $this->doc->getElementById( $itemToRemove );
			if ( $itemToRemoveNode ) {
				$itemToRemoveNode->parentNode->removeChild( $itemToRemoveNode );
			}
		}

		// CSS Classes
		$xpath = new DOMXpath( $this->doc );
		foreach ( $itemToRemoveRecords['CLASS'] as $classToRemove ) {
			$elements = $xpath->query( '//*[@class="' . $classToRemove . '"]' );

			foreach ( $elements as $element ) {
				$element->parentNode->removeChild( $element );
			}
		}

		// Tags with CSS Classes
		foreach ( $itemToRemoveRecords['TAG_CLASS'] as $classToRemove ) {
			$parts = explode( '.', $classToRemove );

			$elements = $xpath->query(
				'//' . $parts[0] . '[@class="' . $parts[1] . '"]'
			);

			foreach ( $elements as $element ) {
				$removedElement = $element->parentNode->removeChild( $element );
			}
		}

		// Handle red links with action equal to edit
		$redLinks = $xpath->query( '//a[@class="new"]' );
		foreach ( $redLinks as $redLink ) {
			// PHP Bug #36795 — Inappropriate "unterminated entity reference"
			$spanNode = $this->doc->createElement( "span", str_replace( "&", "&amp;", $redLink->nodeValue ) );

			if ( $redLink->hasAttributes() ) {
				$attributes = $redLink->attributes;
				foreach ( $attributes as $i => $attribute ) {
					if ( $attribute->name != 'href' ) {
						$spanNode->setAttribute( $attribute->name, $attribute->value );
					}
				}
			}

			$redLink->parentNode->replaceChild( $spanNode, $redLink );
		}

		if ( self::$title->isSpecial( 'Userlogin' ) && self::$isBetaGroupMember ) {
			if ( $userlogin && get_class( $userlogin ) === 'DOMElement' ) {
				$login = $this->renderLogin();
				$loginNode = $this->doc->importNode( $login, true );
				$userlogin->appendChild( $loginNode );
			}
		}

		$content = $this->doc->getElementById( 'content' );

		$contentHtml = $this->doc->saveXML( $content, LIBXML_NOEMPTYTAG );

		if ( self::$isMainPage ) {
			$contentHtml = $this->DOMParseMainPage( $contentHtml );
		}

		$title = htmlspecialchars( self::$title->getText() );
		$htmlTitle = htmlspecialchars( self::$htmlTitle );

		if ( strlen( $contentHtml ) > 4000 && $this->contentFormat == 'XHTML'
			&& self::$device['supports_javascript'] === true
			&& empty( self::$search ) && !self::$isMainPage ) {
			$contentHtml =	$this->headingTransform( $contentHtml );
		} elseif ( $this->contentFormat == 'WML' ) {
			header( 'Content-Type: text/vnd.wap.wml' );
			$contentHtml = $this->headingTransform( $contentHtml );

			// Content removal for WML rendering
			$elements = array( 'span', 'div', 'sup', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'sup', 'sub' );
			foreach ( $elements as $element ) {
				$contentHtml = preg_replace( '#</?' . $element . '[^>]*>#is', '', $contentHtml );
			}

			//Wml for searching
			$searchWml = '<p><input emptyok="true" format="*M" type="text" name="search" value="" size="16" />' .
				'<do type="accept" label="' . self::$messages['mobile-frontend-search-submit'] . '">' .
				'<go href="' . $wgScript . '?title=Special%3ASearch&amp;search=$(search)"></go></do></p>';
			$contentHtml = $searchWml . $contentHtml;
			// Content wrapping
			$contentHtml = $this->createWMLCard( $contentHtml );
			$applicationWmlTemplate = new ApplicationWmlTemplate();
			$options = array(
							'mainPageUrl' => self::$mainPageUrl,
							'randomPageUrl' => self::$randomPageUrl,
							'dir' => self::$dir,
							'code' => self::$code,
							'contentHtml' => $contentHtml,
							'homeButton' => self::$messages['mobile-frontend-home-button'],
							'randomButton' => self::$messages['mobile-frontend-random-button'],
							);
			$applicationWmlTemplate->setByArray( $options );
			$applicationHtml = $applicationWmlTemplate->getHTML();
		}

		if ( $this->contentFormat == 'XHTML' && self::$format != 'json' ) {
			if ( !empty( self::$displayNoticeId ) ) {
				if ( intval( self::$displayNoticeId ) === 1 ) {
					$thanksNoticeTemplate = new ThanksNoticeTemplate();
					$thanksNoticeTemplate->set( 'messages', self::$messages );
					$noticeHtml = $thanksNoticeTemplate->getHTML();
				}
			}

			// header( 'Content-Type: application/xhtml+xml; charset=utf-8' );
			$searchTemplate = $this->getSearchTemplate();
			$searchWebkitHtml = $searchTemplate->getHTML();
			$footerTemplate = $this->getFooterTemplate();
			$footerHtml = $footerTemplate->getHTML();
			$noticeHtml = ( !empty( $noticeHtml ) ) ? $noticeHtml : '';
			$applicationTemplate = $this->getApplicationTemplate();
			$options = array(
							'noticeHtml' => $noticeHtml,
							'htmlTitle' => $htmlTitle,
							'searchWebkitHtml' => $searchWebkitHtml,
							'contentHtml' => $contentHtml,
							'footerHtml' => $footerHtml,
							);
			$applicationTemplate->setByArray( $options );
			$applicationHtml = $applicationTemplate->getHTML();
		}

		if ( self::$format === 'json' ) {
			header( 'Content-Type: application/json' );
			header( 'Content-Disposition: attachment; filename="data.js";' );
			$json_data = array();
			$json_data['title'] = htmlspecialchars ( self::$title->getText() );
			$json_data['html'] = $contentHtml;

			$json = FormatJson::encode( $json_data );

			if ( !empty( self::$callback ) ) {
				$json = urlencode( htmlspecialchars( self::$callback ) ) . '(' . $json . ')';
			}

			wfProfileOut( __METHOD__ );
			return $json;
		}

		wfProfileOut( __METHOD__ );
		return $applicationHtml;
	}

	public function getFooterTemplate() {
		wfProfileIn( __METHOD__ );
		$footerTemplate = new FooterTemplate();
		$logoutHtml = ( !empty( $logoutHtml ) ) ? $logoutHtml : '';
		$options = array(
						'messages' => self::$messages,
						'leaveFeedbackURL' => self::$leaveFeedbackURL,
						'disableMobileSiteURL' => self::$disableMobileSiteURL,
						'viewNormalSiteURL' => self::$viewNormalSiteURL,
						'disableImages' => self::$disableImages,
						'disableImagesURL' => self::$disableImagesURL,
						'enableImagesURL' => self::$enableImagesURL,
						'logoutHtml' => $logoutHtml,
						'code' => self::$code,
						'isBetaGroupMember' => self::$isBetaGroupMember,
						);
		$footerTemplate->setByArray( $options );
		wfProfileOut( __METHOD__ );
		return $footerTemplate;
	}

	public function getSearchTemplate() {
		global $wgExtensionAssetsPath, $wgMobileFrontendLogo;
		wfProfileIn( __METHOD__ );
		$searchTemplate = new SearchTemplate();
		$options = array(
						'searchField' => self::$searchField,
						'mainPageUrl' => self::$mainPageUrl,
						'randomPageUrl' => self::$randomPageUrl,
						'messages' => self::$messages,
						'hideSearchBox' => self::$hideSearchBox,
						'hideLogo' => self::$hideLogo,
						'buildLanguageSelection' => self::buildLanguageSelection(),
						'device' => self::$device,
						'wgExtensionAssetsPath' => $wgExtensionAssetsPath,
						'wgMobileFrontendLogo' => $wgMobileFrontendLogo,
						);
		$searchTemplate->setByArray( $options );
		wfProfileOut( __METHOD__ );
		return $searchTemplate;
	}

	public function getApplicationTemplate() {
		global $wgAppleTouchIcon, $wgExtensionAssetsPath, $wgScriptPath;
		wfProfileIn( __METHOD__ );
		$applicationTemplate = new ApplicationTemplate();
		$options = array(
						'dir' => self::$dir,
						'code' => self::$code,
						'placeholder' => self::$messages['mobile-frontend-placeholder'],
						'wgAppleTouchIcon' => $wgAppleTouchIcon,
						'isBetaGroupMember' => self::$isBetaGroupMember,
						'device' => self::$device,
						'wgExtensionAssetsPath' => $wgExtensionAssetsPath,
						'wgScriptPath' => $wgScriptPath,
						'isFilePage' => self::$isFilePage,
						);
		$applicationTemplate->setByArray( $options );
		wfProfileOut( __METHOD__ );
		return $applicationTemplate;
	}

	public static function buildLanguageSelection() {
		global $wgLanguageCode;
		wfProfileIn( __METHOD__ );
		$output = Html::openElement( 'select',
			array( 'id' => 'languageselection',
				'onchange' => 'javascript:navigateToLanguageSelection();' ) );
		foreach (self::$languageUrls as $languageUrl) {
			if ( $languageUrl['lang'] == $wgLanguageCode ) {
				$output .=	Html::element( 'option',
							array( 'value' => $languageUrl['href'], 'selected' => 'selected' ),
									$languageUrl['language'] );
			} else {
				$output .=	Html::element( 'option',
							array( 'value' => $languageUrl['href'] ),
									$languageUrl['language'] );
			}
		}
		$output .= Html::closeElement( 'select', array() );
		wfProfileOut( __METHOD__ );
		return $output;
	}

	/**
	 * Sets up the default logo image used in mobile view if none is set
	 */
	public function setDefaultLogo() {
		global $wgMobileFrontendLogo, $wgExtensionAssetsPath, $wgDBname, $wgConf;
		wfProfileIn( __METHOD__ );
		if ( $wgMobileFrontendLogo === false ) {
			$wgMobileFrontendLogo = $wgExtensionAssetsPath . '/MobileFrontend/stylesheets/images/mw.png';
		}
		if ( self::$isBetaGroupMember ) {
			list( $site, $lang ) = $wgConf->siteFromDB( $wgDBname );
			if ( $site == 'wikipedia' ) {
				$wgMobileFrontendLogo = '//upload.wikimedia.org/wikipedia/commons/1/16/W_logo_for_beta_test_of_Mobile_Frontend.gif';
			}
		}
		wfProfileOut( __METHOD__ );
	}
}
