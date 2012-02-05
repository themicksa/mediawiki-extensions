<?php

class SkinMobile extends SkinTemplate {
	var $skinname = 'mobile',
		$stylename = 'mobile',
		$template = 'MobileTemplate',
		$useHeadElement = false;

	/**
	 * Overridden to make changes to resource loader
	 *
	 * @param null|OutputPage $out
	 */
	function outputPage( OutputPage $out = null ) {
		$realOut = $this->getOutput();

		// We need to disable all the default RL modules, do that like this
		$realOut->clearAllModules();

		parent::outputPage( $out );
	}

	/**
	 * Skin CSS
	 *
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		$out->addModuleStyles( 'ext.mobileFrontend2' );
	}

	/**
	 * We're too cool for edit links, don't output them
	 *
	 * @param Title $nt
	 * @param $section
	 * @param null $tooltip
	 * @param bool $lang
	 * @return string
	 */
	public function doEditSectionLink( Title $nt, $section, $tooltip = null, $lang = false ) {
		return '';
	}
}

class MobileTemplate extends BaseTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html lang="<?php $this->text( 'lang' ) ?>" dir="<?php $this->text( 'dir' ) ?>" xml:lang="<?php $this->text( 'lang' ) ?>" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php $this->text( 'pagetitle' ) ?></title>

		<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php $this->html( 'csslinks' ) ?>
	</head>
	<body>
	<!-- search/header -->
	<div id="header">
		<div id="searchbox">
			<img src="<?php $this->text( 'mobilelogopath' ) ?>" alt="Logo" id="logo" width="35" height="22" />
			<form action="<?php $this->text( 'wgScript' ) ?>" class="search_bar" method="get">
				<input type="hidden" name="title" value="Special:Search" />

				<div id="sq" class="divclearable">
					<input type="text" name="search" id="search" size="22" value="" autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="1024" />
					<div class="clearlink" id="clearsearch"></div>
				</div>
				<button id="goButton" type="submit"></button>
			</form>
		</div>
	</div>

	<!-- content -->
	<div class="show" id="content_wrapper">
		<?php $this->html( 'bodycontent' ) ?>
	</div>

	<!-- footer -->
	<div id="footer">
		<div class="nav" id="footmenu">
			<div class="mwm-notice">
				<a href="#"><?php $this->msg( 'mobile-frontend2-regular-site' ) ?></a> | <a href="#"><?php $this->msg( 'mobile-frontend2-disable-images' ) ?></a>

				<div id="perm">
					<a href="#"><?php $this->msg( 'mobile-frontend2-perm-stop-redirect' ) ?></a>
				</div>
			</div>
			<div id="copyright">
				<?php $this->msg( 'mobile-frontend2-copyright' ) ?>
			</div>
		</div>
	</div>

	</body>
	</html>
<?php
	}
}