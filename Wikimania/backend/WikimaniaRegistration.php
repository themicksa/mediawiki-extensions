<?php
/**
 * Class referring to a specific registration
 */
class WikimaniaRegistration extends HTMLForm {

	/**
	 * @param $wm Wikimania
	 * @param $context ContextSource
	 */
	public function  __construct( Wikimania $wm, $context = null ) {
		parent::__construct( $this->getFields( $wm, $context->getUser() ), $context, 'wikimania' );
		$this->mHeader = $this->getHeader( $wm );
		$this->mId = 'mwe-wmreg-form';
	}

	function getBody() {
		return $this->displaySection( $this->mFieldTree, '', 'mwe-wmreg-page-' );
	}


	/**
	 * @param $u user
	 * @return string
	 */
	public static function generateRegistrationID( User $u ) {
		$str = $u->getName() . ":" . microtime() . ":" . wfGetIP();
		return substr( sha1( $str ), 0, 5 );
	}

	/**
	 * @param $wm Wikimania
	 * @param $u User
	 * @return array
	 */
	private function getFields( Wikimania $wm, User $u ) {
		static $fields;
		if( !$fields ) {
			$langList = array_flip( LanguageNames::getNames( $u->getOption( 'lang') ) );
			$langListWithEmpty = $langList;
			$langListWithEmpty[''] = '';
			$fields = array(
				/** PERSONAL INFORMATION **/
				'reg_fname' => array(
					'type' => 'text',
					'label-message' => 'wikimania-reg-fname',
					'section' => 'personal/personal-info',
					'required' => true,
				),
				'reg_lname' => array(
					'type' => 'text',
					'label-message' => 'wikimania-reg-lname',
					'section' => 'personal/personal-info',
					'required' => true,
				),
				'reg_gender' => array(
					'type' => 'radio',
					'label-message' => 'wikimania-reg-gender',
					'options' => self::getGenderPossibilities(),
					'section' => 'personal/personal-info',
					'required' => true,
				),
				'reg_country' => array(
					'type' => 'select',
					'options' => array(),
					'section' => 'personal/personal-info',
					'required' => true,
				),
				/** LINGUISTIC ABILItIES **/
				'langn' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-langn',
					'options' => $langList,
					'section' => 'personal/linguistic-abilities',
					'required' => true,
				),
				'lang1' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang1',
					'options' => $langListWithEmpty,
					'section' => 'personal/linguistic-abilities',
				),
				'lang2' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang2',
					'options' => $langListWithEmpty,
					'section' => 'personal/linguistic-abilities',
				),
				'lang3' => array(
					'type' => 'select',
					'label-message' => 'wikimania-reg-lang3',
					'options' => $langListWithEmpty,
					'section' => 'personal/linguistic-abilities',
				),

				'days' => array(
					'type' => 'multiselect',
					'label-message' => 'wikimania-reg-participation-days',
					'options' => array(
						'Day 1' => '1',
						'Day 2' => '2'
					),
					'section' => 'participation/days'
				),
			);
		}
		return $fields;
	}

	private function getHeader( Wikimania $wm ) {
		$year = $wm->getYear();
		$html = ''
			. '<img src="' . $wm->getBannerUrl() . '" id="mwe-wmreg-banner" />'

			// Arrow steps
			. '<ul id="mwe-wmreg-steps" style="display:none;">'
			.   '<li id="mwe-wmreg-step-welcome"><div> Welcome</div></li>'
			.   '<li id="mwe-wmreg-step-personal"><div>Personal Info</div></li>'
			.   '<li id="mwe-wmreg-step-participation"><div>Participation</div></li>'
			.   '<li id="mwe-wmreg-step-payment"><div>Payment</div></li>'
			.   '<li id="mwe-wmreg-step-thanks"><div>Thanks</div></li>'
			. '</ul>'

			. '<div id="mwe-wmreg-stepdiv-welcome" class="mwe-wmreg-stepdiv" style="display:none;">'
			.   '<br clear="all" />'
			.   $this->msg( "wikimania{$year}-welcome-text" )->parse()
			.   '<div class="mwe-wmreg-buttons">'
			.     '<button class="mwe-wmreg-button-next">Next</button>'
			.   '</div>'
			. '</div>';

		return $html;
	}

	/**
	 * @static
	 * @return array
	 */
	private static function getGenderPossibilities() {
		return array(
			wfMsg( 'gender-male') => 'male',
			wfMsg( 'gender-female') => 'female',
			wfMsg( 'wikimania-reg-gender-decline') => 'decline'
		);
	}
}
