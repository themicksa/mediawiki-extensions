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
	<div class="show" id="content_wrapper">
		<?php $this->html( 'bodycontent' ) ?>
	</div>
	</body>
	</html>
<?php
	}
}