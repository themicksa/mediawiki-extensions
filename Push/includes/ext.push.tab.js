/**
 * JavasSript for the Push tab in the Push extension.
 * @see http://www.mediawiki.org/wiki/Extension:Push
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function($) { $( document ).ready( function() {
	
	// Compatibility with pre-RL code.
	// Messages will have been loaded into wgPushMessages.
	if ( typeof mediaWiki === 'undefined' ) {
		mediaWiki = new Object();
		
		mediaWiki.msg = function( message ) {
			return window.wgPushMessages[message];
		}
	}
	
	$('.push-button').click(function() {
		this.disabled = true;
		this.innerHTML = mediaWiki.msg( 'push-button-pushing' );
		
		getLocalArtcileAndContinue(
			this,
			$(this).attr( 'pushtarget' )
		);
	});
	
	function getLocalArtcileAndContinue( sender, targetUrl ) {
		var pageName = $('#pageName').attr('value'); 
		
		$.getJSON(
			wgScriptPath + '/api.php',
			{
				'action': 'query',
				'format': 'json',
				'prop': 'revisions',
				'rvprop': 'timestamp|user|comment|content',
				'titles': pageName,
			},
			function( data ) {
				if ( data.error ) {
					handleError( sender, targetUrl, data.error );
				}
				else {
					sender.innerHTML = sender.innerHTML + '.';
					for (first in data.query.pages) break;
					getTokenAndContinue( sender, targetUrl, data.query.pages[first] );
				}
			}
		); 		
	}
	
	function getTokenAndContinue( sender, targetUrl, page ) {
		$.getJSON(
			targetUrl + '/api.php',
			{
				'action': 'query',
				'format': 'json',
				'intoken': 'edit',
				'prop': 'info',
				'titles': page.title,
			},
			function( data ) {
				if ( data.error ) {
					handleError( sender, targetUrl, data.error );
				}
				else {
					sender.innerHTML = sender.innerHTML + '.';
					for (first in data.query.pages) break;
					doPush( sender, targetUrl, page, data.query.pages[first].edittoken );
				}
			}
		); 
	}
	
	function doLoginAndContinue() {
		
	}
	
	function doPush( sender, targetUrl, page, token ) {
		var summary = mediaWiki.msg( 'push-import-revision-message' );
		summary = summary.replace( '$1', $('#siteName').attr('value') );
		summary = summary.replace( '$2', page.revisions[0].user );
		
		var comment = '';
		if ( page.revisions[0].comment ) {
			comment = mediaWiki.msg( 'push-import-revision-comment' );
			comment = comment.replace( '$1', page.revisions[0].comment );
		}
		
		summary = summary.replace( '$3', comment );
		
		$.post( 
			targetUrl + '/api.php',
			{
				'action': 'edit',
				'format': 'json',
				'token': token,
				'title': page.title,
				'summary': summary,
				'text': page.revisions[0].*
			},
			function( data ) {
				if ( data.error ) {
					handleError( sender, targetUrl, data.error );
				}
				else {
					sender.innerHTML = mediaWiki.msg( 'push-button-completed' );
				}
			}
		);		
	}
	
	function handleError( sender, targetUrl, error ) {
		alert( error.info );
		sender.innerHTML = mediaWiki.msg( 'push-button-failed' );		
	}
	
} ); })(jQuery);