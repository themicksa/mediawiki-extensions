<?php
/**
 * Register for Wikimania
 */
class SpecialRegisterForWikimania extends SpecialPage {
	public function __construct() {
		parent::__construct( 'RegisterForWikimania', 'wikimania-register' );
	}

	public function execute( $par = '' ) {
		// Get our Wikimania class
		$wikimania = Wikimania::getWikimania();

		$out = $this->getOutput();

		$this->setHeaders();
		// Add the year to the title
		$out->setPageTitle(
			$this->msg( 'registerforwikimania', $wikimania->getYear() )
		);

		$out->addModules( 'ext.wikimania' );

		// Add the banner to the beginning of the page
		$out->addHTML(
			Html::element( 'img', array( 'src' => $wikimania->getBannerUrl() ) )
		);

		$form = new WikimaniaRegistration( Wikimania::getWikimania(), $this->getContext() );
		$form->show();
	}
}
