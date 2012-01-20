/**
 * QUnit tests for WebFonts
 *
 * @file
 * @author Santhosh Thottingal, Amir E. Aharoni
 * @copyright Copyright © 2012 Santhosh Thottingal, Amir E. Aharoni
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

module( 'ext.webfonts', QUnit.newMwEnvironment() );

test( '-- Initial check', function() {
	expect(1);

	if ( !mw.webfonts.isBrowserSupported ) {
		// TODO: need a better way to test this
		ok( mw.webfonts, 'The WebFonts extension is not supposed to run in a blacklisted browser - '
			+ navigator.appName + ' ' + navigator.userAgent );
		return;
	}

	ok( mw.webfonts, 'mw.webfonts is defined and the browser is supported' );
} );

test( '-- Application of a web font to the page and its removal', function() {
	if ( !mw.webfonts.isBrowserSupported ) {
		return;
	}

	expect( 27 );

	var invalidFont = 'NonExistingFont';
	assertTrue( mw.webfonts.set( invalidFont ) === undefined, 'A non-existent font is not initialized' );
	// TODO: test that the right thing was written to the log

	var $body = $( 'body' );
	var bodyLang = $body.attr( 'lang' );
	var oldConfig = {
		fontFamily: $body.css( 'font-family' ),
		fontSize: $body.css( 'font-size' )
	};
	var teluguFont = mw.webfonts.config.languages.te[0];
	$body.attr( 'lang', 'te' );

	ok( $( 'body' ).append( "<input class='webfonts-testing-element'>input content</input>"), 'An input element for testing was appended to body' );
	var $inputElement =  $( 'input.webfonts-testing-element' );
	assertTrue( $inputElement !== [], 'The input test element is defined' );
	ok( $( 'body' ).append( "<select class='webfonts-testing-element'>select content</select>"), 'A select element for testing was appended to body' );
	var $selectElement =  $( 'select.webfonts-testing-element' );
	assertTrue( $selectElement !== [], 'The select test element is defined' );
	ok( $( 'body' ).append( "<textarea class='webfonts-testing-element'>textarea content</textarea>"), 'A textarea element for testing was appended to body' );
	var $textareaElement =  $( 'textarea.webfonts-testing-element' );
	assertTrue( $textareaElement !== [], 'The textarea test element is defined' );

	ok( mw.webfonts.set( teluguFont ), 'Attempted to load a Telugu font for the whole page' );
	var fallbackFonts = 'Helvetica, Arial, sans-serif';
	deepEqual( oldConfig, mw.webfonts.oldconfig, 'Previous body css was saved properly' );

	// Font application
	var expectedFontFamilyValue = fontFamilyList( "'" + teluguFont + "', " + fallbackFonts );
	deepEqual( fontFamilyList( $body.css( 'font-family' ) ),
		expectedFontFamilyValue, 'The web font was applied to font-family of body' );
	deepEqual( fontFamilyList( $inputElement.css( 'font-family' ) ),
		expectedFontFamilyValue, 'The web font was applied to font-family of input' );
	deepEqual( fontFamilyList( $selectElement.css( 'font-family' ) ),
		expectedFontFamilyValue, 'The web font was applied to font-family of select' );
	deepEqual( fontFamilyList( $textareaElement.css( 'font-family' ) ),
		expectedFontFamilyValue, 'The web font was applied to font-family of textarea' );

	// Cookie set
	equals( $.cookie( 'webfonts-font' ), teluguFont, 'Correct cookie for the font was set' );

	// Reset everything
	ok( mw.webfonts.set( false ) === undefined, 'Reset body after testing font application' );
	equals( $body.css( 'font-family' ), oldConfig.fontFamily, 'Previous font-family for body was restored' );
	equals( $body.css( 'font-size' ), oldConfig.fontSize, 'Previous font-size for body was restored' );
	equals( $inputElement.css( 'font-family' ), oldConfig.fontFamily, 'Previous font-family for body was restored' );
	equals( $inputElement.css( 'font-size' ), oldConfig.fontSize, 'Previous font-size for body was restored' );
	equals( $selectElement.css( 'font-family' ), oldConfig.fontFamily, 'Previous font-family for the select element was restored' );
	equals( $selectElement.css( 'font-size' ), oldConfig.fontSize, 'Previous font-size for the select element restored' );
	equals( $textareaElement.css( 'font-family' ), oldConfig.fontFamily, 'Previous font-family for the textarea element was restored' );
	equals( $textareaElement.css( 'font-size' ), oldConfig.fontSize, 'Previous font-size for the textarea element was restored' );

	ok( $inputElement.remove(), 'The input test element was removed from body' );
	ok( $selectElement.remove(), 'The select test element was removed from body' );
	ok( $textareaElement.remove(), 'The textarea test element was removed from body' );

	// Cookie set
	equals( $.cookie( 'webfonts-font' ), 'none', 'The cookie was removed' );

	$body.attr( 'lang', bodyLang );
} );

test( '-- Dynamic font loading', function() {
	if ( !mw.webfonts.isBrowserSupported ) {
		return;
	}

	expect( 7 );

	var validFontName = mw.webfonts.config.languages.hi[0];
	mw.webfonts.fonts = [];
	var cssRulesLength = document.styleSheets.length;
	assertTrue( mw.webfonts.addFont( validFontName ), 'Add a Devanagari font' );
	assertTrue( $.inArray( validFontName, mw.webfonts.fonts ) >= 0, 'Devanagari font loaded' );
	assertTrue( cssRulesLength + 1 === document.styleSheets.length, 'New css rule added to the document' );
	var loadedFontsSize = mw.webfonts.fonts.length;
	assertTrue( mw.webfonts.addFont( validFontName ), 'Add the Devanagari font again' );
	assertTrue( loadedFontsSize === mw.webfonts.fonts.length, 'A font that is already loaded is not loaded again' );
	assertFalse( mw.webfonts.addFont( 'Some non-existing font' ), 'addFont returns false if the font was not found' );
	assertTrue( cssRulesLength + 1 === document.styleSheets.length, 'Loading the font does not add new css rules' );
} );

test( '-- Dynamic font loading based on lang attribute', function() {
	if ( !mw.webfonts.isBrowserSupported ) {
		return;
	}

	expect( 15 );

	mw.webfonts.fonts = [];
	mw.config.set( {
		wgLanguage: "en",
		wgUserVariant: "en",
		wgUserLanguage: "en",
		wgPageContentLanguage: "en"
	} );
	
	ok( $( 'body' ).append( "<p class='webfonts-testing-lang-attr'>Some content</p>"), 'An element for testing lang-based loading was appended to body' );
	var $testElement = $( 'p.webfonts-testing-lang-attr' );
	assertTrue( $testElement !== [], 'The test element is defined' );

	ok( mw.webfonts.loadFontsForLangAttr(), 'Attempted to load fonts for the lang attribute' );
	assertFalse( $testElement.hasClass( 'webfonts-lang-attr' ), 'The element has no webfonts-lang-attr class since there is no lang attribute' );

	ok( $testElement.attr( 'lang', 'en' ), 'The lang attribute of the test element was set to en (English)' );
	ok( mw.webfonts.loadFontsForLangAttr(), 'Attempted to load fonts for the lang attribute en' );
	assertFalse( $testElement.hasClass( 'webfonts-lang-attr' ), 'The test element has no webfonts-lang-attr class since en lang has no fonts available' );

	var tamilFont = mw.webfonts.config.languages.ta[0];
	ok( $testElement.attr( 'lang', 'ta' ), 'Set lang attribute to ta (Tamil)' );
	ok( mw.webfonts.loadFontsForLangAttr(), 'Attempted to load fonts for the lang attribute ta' );
	assertTrue( $testElement.hasClass( 'webfonts-lang-attr' ), 'The test element has webfonts-lang-attr class' );
	assertTrue( $.inArray( tamilFont, mw.webfonts.fonts ) >= 0, 'Tamil font loaded' );
	assertTrue( isFontFaceLoaded( tamilFont ), 'New css rule font-face was added to the document for Tamil font' );

	ok( mw.webfonts.reset(), 'Reset webfonts after testing application by lang' );
	assertFalse( $testElement.hasClass( 'webfonts-lang-attr' ), 'The testing element has no webfonts-lang-attr since we reset it' );
	// equals( $( 'body' ).find( '*[lang]' ).length, 0, 'There are no elements with the webfonts-lang-attr class' );

	ok( $testElement.remove(), 'The test element was removed from body' );
} );

test( '-- Dynamic font loading based on font-family style attribute', function() {
	if ( !mw.webfonts.isBrowserSupported ) {
		return;
	}

	expect( 14 );

	mw.webfonts.fonts = [];
	ok( $( 'body' ).append( "<p class='webfonts-testing-font-family-style'>Some content</p>" ), 'An element for testing font-family loading was appended to body' );
	var $testElement = $( 'p.webfonts-testing-font-family-style' );
	assertTrue(  $testElement !== [], 'The test element is defined' );

	var latinWebFont = 'RufScript';
	var fallbackFonts = 'Helvetica, Arial, sans-serif';
	$testElement.attr( 'style','font-family: ' + latinWebFont + ', ' + fallbackFonts );
	assertTrue( $.inArray( latinWebFont, mw.webfonts.fonts ) === -1, 'Latin font not loaded yet' );
	ok( mw.webfonts.loadFontsForFontFamilyStyle(), 'Loaded fonts from font-family' );
	assertTrue( $.inArray( latinWebFont, mw.webfonts.fonts ) >= 0, 'Latin font loaded' );
	assertTrue( isFontFaceLoaded( latinWebFont ), 'New css rule added to the document for Latin' );

	var invalidFont = 'NonExistingFont';
	$testElement.attr( 'style','font-family: ' + invalidFont + ', ' + fallbackFonts );
	ok( mw.webfonts.loadFontsForFontFamilyStyle(), 'Attempted to load non-existing fonts specified in font-family' );
	assertTrue( $.inArray( invalidFont, mw.webfonts.fonts ) === -1, 'Font not loaded since it is not existing, including fallback fonts' );
	assertFalse( isFontFaceLoaded( invalidFont ), 'No new css rule added to the document since the font does not exist' );

	var malayalamFont = mw.webfonts.config.languages.ml[0];
	$testElement.attr( 'style', 'font-family: ' + invalidFont + ', ' + malayalamFont + ', ' + fallbackFonts );
	assertTrue( $.inArray( malayalamFont, mw.webfonts.fonts ) === -1, 'Fallback font not loaded yet' );
	ok( mw.webfonts.loadFontsForFontFamilyStyle(), 'Loading fonts from font-family' );
	assertTrue( $.inArray( malayalamFont, mw.webfonts.fonts ) >= 0, 'A fallback font was loaded' );
	assertTrue( isFontFaceLoaded( malayalamFont ), 'New css rule added to the document for fallback font' );

	ok( $testElement.remove() );
} );

test( '-- Build the menu', function() {
	if ( !mw.webfonts.isBrowserSupported ) {
		return;
	}

	expect( 9 );

	var oldFonts = mw.webfonts.fonts;
	var fonts = [];
	assertFalse( mw.webfonts.buildMenu( fonts ), 'Build the menu with empty fonts list' );
	fonts = mw.webfonts.config.languages.hi;
	ok( mw.webfonts.buildMenu( fonts ), 'Build the menu with Hindi fonts list' );
	equals( $( 'li#pt-webfont' ).length, 1, 'There should be one and only one menu at any time' );
	ok( mw.webfonts.buildMenu( fonts ), 'Build the menu with Hindi fonts list again' );
	equals( $( 'li#pt-webfont' ).length, 1, 'There should be one and only one menu at any time' );
	equals( $( 'ul#webfonts-fontsmenu li' ).length,  fonts.length + 2, 'Number of menu items is number of availables fonts, a help link and reset item' );
	equals( $( 'li.webfont-help-item').length, 1, 'Help link exists' );
	equals( $( 'input#webfont-none' ).length, 1, 'Reset link exists' );
	if (oldFonts.length) {
		assertTrue( mw.webfonts.buildMenu( oldFonts ), 'Restore the menu' );
	} else {
		assertFalse( mw.webfonts.buildMenu( oldFonts ), 'Restore the menu' );
	}
} );

// Tests end here

isFontFaceLoaded = function( fontFamilyName ) {
	var lastStyleIndex = document.styleSheets.length - 1;
	
	// Iterate from last.
	for( var styleIndex = lastStyleIndex; styleIndex > 0; styleIndex-- ) {
		var lastStyleSheet = document.styleSheets[styleIndex];
		if ( !lastStyleSheet ) { continue; }
		if ( !lastStyleSheet.cssRules[0] ) { continue; }
		var cssText =  lastStyleSheet.cssRules[0].cssText;
		if ( cssText.indexOf( '@font-face' ) >= 0 &&  cssText.indexOf( fontFamilyName ) >= 0 ) {
			return true;
		}
	}
	
	return false;
};

// Convert a font-family string to an array. This is needed
// because browsers change the string by adding or removing spaces,
// so the string cannot be compared in a uniform way.
fontFamilyList = function( fontFamilyString ) {
	// Create a list
	var fontList = fontFamilyString.split( /, */ );

	// Remove the quotes from font names
	for ( var fontIndex = 0; fontIndex < fontList.length; ++fontIndex) {
		fontList[fontIndex] = fontList[fontIndex].replace( /^["']/, '' );
		fontList[fontIndex] = fontList[fontIndex].replace( /["']$/, '' );
	}

	return fontList;
};
