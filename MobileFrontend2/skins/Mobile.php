<?php

class SkinMobile extends SkinTemplate {
	var $skinname = 'mobile',
		$stylename = 'mobile',
		$template = 'MobileTemplate',
		$useHeadElement = false;
}

class MobileTemplate extends BaseTemplate {

	/**
	 * Main function, used by classes that subclass QuickTemplate
	 * to show the actual HTML output
	 */
	public function execute() {
?>
		Hello!
<?php
	}
}