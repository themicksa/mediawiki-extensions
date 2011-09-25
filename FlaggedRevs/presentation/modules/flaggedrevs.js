/**
 * FlaggedRevs Stylesheet
 * @author Aaron Schulz
 * @author Krinkle <krinklemail@gmail.com> 2011
 */

window.FlaggedRevs = {
	/* Dropdown collapse timer */
	'boxCollapseTimer': null,

	/* Startup function */
	'init': function() {
		// Enables rating detail box
		var toggle = $('#mw-fr-revisiontoggle');
		if ( toggle.length ) {
			toggle.css('display','inline'); /* show toggle control */
			this.hideBoxDetails(); /* hide the initially displayed ratings */
		}
		// Enables diff detail box
		toggle = $('#mw-fr-difftoggle');
		if ( toggle.length ) {
			toggle.css('display','inline'); /* show toggle control */
			$('#mw-fr-stablediff').hide();
		}
		// Enables log detail box
		toggle = $('#mw-fr-logtoggle');
		if ( toggle.length ) {
			toggle.css('display','inline'); /* show toggle control */
			$('#mw-fr-logexcerpt').hide();
		}
		// Enables changing of save button when "review this" checkbox changes */
		$('#wpReviewEdit').click( FlaggedRevs.updateSaveButton );
	},

	/* Expands flag info box details */
	'showBoxDetails': function() {
		$('#mw-fr-revisiondetails').css('display','block');
	},

	/* Collapses flag info box details */
	'hideBoxDetails': function( event ) {
		$('#mw-fr-revisiondetails').css('display','none');
	},

	/* Toggles flag info box details for (+/-) control */
	'toggleBoxDetails': function() {
		var toggle = $('#mw-fr-revisiontoggle');
		var ratings = $('#mw-fr-revisiondetails');
		if ( toggle.length && ratings.length ) {
			// Collapsed -> expand
			if ( ratings.css('display') == 'none' ) {
				this.showBoxDetails();
				toggle.text( mw.msg('revreview-toggle-hide') );
			// Expanded -> collapse
			} else {
				this.hideBoxDetails();
				toggle.text( mw.msg('revreview-toggle-show') );
			}
		}
	},

	/* Expands flag info box details on mouseOver */
	'onBoxMouseOver': function( event ) {
		window.clearTimeout( this.boxCollapseTimer );
		this.boxCollapseTimer = null;
		this.showBoxDetails();
	},

	/* Hides flag info box details on mouseOut *except* for event bubbling */
	'onBoxMouseOut': function( event ) {
		if ( !this.isMouseOutBubble( event, 'mw-fr-revisiontag' ) ) {
			this.boxCollapseTimer = window.setTimeout( this.hideBoxDetails, 150 );
		}
	},

	/* Checks if mouseOut event is for a child of parentId */
	'isMouseOutBubble': function( event, parentId ) {
		var toNode = null;
		if ( event.relatedTarget !== undefined ) {
			toNode = event.relatedTarget; // FF/Opera/Safari
		} else {
			toNode = event.toElement; // IE
		}
		if ( toNode ) {
			var nextParent = toNode.parentNode;
			while ( nextParent ) {
				if ( nextParent.id == parentId ) {
					return true; // event bubbling
				}
				nextParent = nextParent.parentNode; // next up
			}
		}
		return false;
	},

	/* Toggles diffs */
	'toggleDiff': function() {
		var diff = $('#mw-fr-stablediff');
		var toggle = $('#mw-fr-difftoggle');
		if ( diff.length && toggle.length ) {
			if ( diff.css('display') == 'none' ) {
				diff.show( 'slow' );
				toggle.children('a').text( mw.msg('revreview-diff-toggle-hide') );
			} else {
				diff.hide( 'slow' );
				toggle.children('a').text( mw.msg('revreview-diff-toggle-show') );
			}
		}
	},

	/* Toggles log excerpts */
	'toggleLog': function() {
		var log = $('#mw-fr-logexcerpt');
		var toggle = $('#mw-fr-logtoggle');
		if ( log.length && toggle.length ) {
			if ( log.css('display') == 'none' ) {
				log.show();
				toggle.children('a').text( mw.msg('revreview-log-toggle-hide') );
			} else {
				log.hide();
				toggle.children('a').text( mw.msg('revreview-log-toggle-show') );
			}
		}
	},

	/* Toggles log excerpts */
	'toggleLogDetails': function() {
		var log = $('#mw-fr-logexcerpt');
		var toggle = $('#mw-fr-logtoggle');
		if ( log.length && toggle.length ) {
			if ( log.css('display') == 'none' ) {
				log.show();
				toggle.children('a').text( mw.msg('revreview-log-details-hide') );
			} else {
				log.hide();
				toggle.children('a').text( mw.msg('revreview-log-details-show') );
			}
		}
	},

	/* Update save button when "review this" checkbox changes */
	'updateSaveButton': function() {
		var save = $('#wpSave');
		var checkbox = $('#wpReviewEdit');
		if ( save.length && checkbox.length ) {
			// Review pending changes
			if ( checkbox.attr('checked') ) {
				save.val( mw.msg('savearticle') );
				save.attr( 'title',
					mw.msg('tooltip-save') + ' [' + mw.msg('accesskey-save') + ']' );
			// Submit for review
			} else {
				save.val( mw.msg('revreview-submitedit') );
				save.attr( 'title',
					mw.msg('revreview-submitedit-title') + ' [' + mw.msg('accesskey-save') + ']' );
			}
		}
		mw.util.updateTooltipAccessKeys( [ save ] ); // update accesskey in save.title
	}
};

// Perform some onload (which is when this script is included) events:
FlaggedRevs.init();
