<?php

/**
 * Static class with utility functions for the Education Program extension.
 *
 * @since 0.1
 *
 * @file EPUtils.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPUtils {

	/**
	 * Create a log entry using the provided info.
	 * Takes care about the logging interface changes in MediaWiki 1.19.
	 * 
	 * @since 0.1
	 * 
	 * @param array $info
	 */
	public static function log( array $info ) {
		$user = array_key_exists( 'user', $info ) ? $info['user'] : $GLOBALS['wgUser'];
		
		if ( $info !== false ) {
			if ( class_exists( 'ManualLogEntry' ) ) {
				$logEntry = new ManualLogEntry( $info['type'], $info['subtype'] );

				$logEntry->setPerformer( $user );
				$logEntry->setTarget( $info['title'] );
				
				if ( array_key_exists( 'comment', $info ) ) {
					$logEntry->setComment( $info['comment'] );
				}
				
				if ( array_key_exists( 'parameters', $info ) ) {
					$logEntry->setParameters( $info['parameters'] );
				}

				$logid = $logEntry->insert();
				$logEntry->publish( $logid );
			}
			else {
				// Compatibility with MediaWiki 1.18.
				$log = new LogPage( $info['type'] );

				$log->addEntry(
					$info['subtype'],
					$info['title'],
					array_key_exists( 'comment', $info ) ? $info['comment'] : '',
					array_key_exists( 'parameters', $info ) ? $info['parameters'] : array(),
					$user
				);
			}
		}
	}
	
	/**
	 * Returns a list of country names that can be used by
	 * a select input localized in the lang of which the code is provided.
	 * 
	 * @since 0.1
	 * 
	 * @param string $langCode
	 * 
	 * @return array
	 */
	public static function getCountryOptions( $langCode ) {
		return self::getKeyPrefixedValues( CountryNames::getNames( $langCode ) );
	}

	/**
	 * Returns a list of language names that can be used by
	 * a select input localized in the lang of which the code is provided.
	 *
	 * @since 0.1
	 *
	 * @param string $langCode
	 *
	 * @return array
	 */
	public static function getLanguageOptions( $langCode ) {
		return self::getKeyPrefixedValues( LanguageNames::getNames( $langCode ) );
	}

	/**
	 * Returns the array but with each value prefixed by it's provided key.
	 *
	 * @since 0.1
	 *
	 * @param array $list
	 *
	 * @return array
	 */
	protected static function getKeyPrefixedValues( array $list ) {
		return array_merge(
			array( '' => '' ),
			array_combine(
				array_map(
					function( $value, $key ) {
						return $key . ' - ' . $value;
					} ,
					array_values( $list ),
					array_keys( $list )
				),
				array_keys( $list )
			)
		);
	}

}
