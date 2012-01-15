( function ( $, mw, undefined ) {

var WikimaniaRegistration = function() {
	// TODO constructor things
};


WikimaniaRegistration.prototype = {
	stepNames: [ 'welcome', 'personal', 'participation' ],
	currentStepName: undefined,

	/**
	 * Creates the interface for the registration form
	 */
	createInterface: function() {
		var _this = this;

		// Move the banner into the welcome div
		$( '#mwe-wmreg-banner' )
			.prependTo( '#mwe-wmreg-stepdiv-welcome' );

		// construct the arrow steps from the UL in the HTML
		$( '#mwe-wmreg-steps' )
			.addClass( 'ui-helper-clearfix ui-state-default ui-widget ui-helper-reset ui-helper-clearfix' )
			.arrowSteps()
			.show();

		// make all stepdiv proceed buttons into jquery buttons
		$( '.mwe-wmreg-stepdiv .mwe-wmreg-buttons button' )
			.button()
			.css( { 'margin-left': '1em' } );

		// Handle the next button on the welcome page
		$( '#mwe-wmreg-stepdiv-welcome .mwe-wmreg-button-next' )
			.click( function() {
				_this.moveToStep( 'personal' );
				return false;
			} );

		// Move the fieldsets inside of divs
		$( '#mwe-wmreg-form > fieldset' ).each( function() {
			var $this = $(this),
				id = $this.attr('id'),
				page;

			// Make sure the id starts with 'mwe-wmreg-page-'
			if ( id.substr( 0, 15 ) !== 'mwe-wmreg-page-' ) {
				return;
			}
			page = id.substr( 15 );

			$( '<div class="mwe-wmreg-stepdiv">' )
				.attr( 'id', 'mwe-wmreg-stepdiv-' + page )
				.appendTo( $( '#mwe-wmreg-form' ) )
				.append( $this.attr( 'id', null ) )
				.append(
					$( '<div class="mwe-wmreg-buttons">' )
						.append( $( '<button class="mwe-wmreg-button-next">Next</button>' ).button() )
				);

		} );

		// Hide the submit button
		$( '#mwe-wmreg-form > .mw-htmlform-submit' ).hide();

		// Move to the welcome step
		this.moveToStep( 'welcome' );
	},

	/**
	 * Moves to the given step on the form
	 */
	moveToStep: function( selectedStepName ) {
		if( this.currentStepName === selectedStepName ) {
			// already there!
			return;
		}

		// scroll to the top of the page (the current step might have been very long, vertically)
		$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );

		$.each( this.stepNames, function( i, stepName ) {

			// the step's contents
			var $stepDiv = $( '#mwe-wmreg-stepdiv-' + stepName );

			if ( selectedStepName === stepName ) {
				$stepDiv.show();
			} else {
				$stepDiv.hide();
			}

		} );

		$( '#mwe-wmreg-steps' ).arrowStepsHighlight( '#mwe-wmreg-step-' + selectedStepName );

		this.currentStepName = selectedStepName;
	}
};

$( document ).ready( function () {
	var form = new WikimaniaRegistration();
	form.createInterface();
} );

} )( jQuery, mediaWiki );