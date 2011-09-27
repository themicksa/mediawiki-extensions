/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:Contest
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { $( document ).ready( function() {

	function deleteSurvey( options, successCallback, failCallback ) {
		$.post(
			wgScriptPath + '/api.php',
			{
				'action': 'deletecontest',
				'format': 'json',
				'ids': options.id,
				'token': options.token
			},
			function( data ) {
				if ( data.success ) {
					successCallback();
				} else {
					failCallback( mw.msg( 'contest-special-delete-failed' ) );
				}
			}
		);	
	}
	
	$( '.contest-delete' ).click( function() {
		$this = $( this );
		
		if ( confirm( mw.msg( 'contest-special-confirm-delete' ) ) ) {
			deleteSurvey(
				{
					id: $this.attr( 'data-contest-id' ),
					token: $this.attr( 'data-contest-token' )
				},
				function() {
					$this.closest( 'tr' ).slideUp( 'slow', function() { $( this ).remove(); } );
				},
				function( error ) {
					alert( error );
				}
			);
		}
		return false;
	} );
	
} ); })( window.jQuery, window.mediaWiki );