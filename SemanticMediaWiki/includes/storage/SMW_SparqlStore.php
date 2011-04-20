<?php

/**
 * SPARQL implementation of SMW's storage abstraction layer.
 *
 * @author Markus Krötzsch
 *
 * @file
 * @ingroup SMWStore
 */

/**
 * Storage access class for using SMW's SPARQL database for keeping semantic
 * data.
 *
 * @note For now, the store keeps an underlying SMWSQLStore2 running for
 * completeness. This might change in the future.
 *
 * @ingroup SMWStore
 */
class SMWSparqlStore extends SMWSQLStore2 {

	public function deleteSubject( Title $subject ) {
		$dataItem = SMWDIWikiPage::newFromTitle( $subject );
		$expResource = SMWExporter::getDataItemExpElement( $dataItem );
		$this->deleteSparqlData( $expResource );
		parent::deleteSubject( $subject );
	}

	public function changeTitle( Title $oldtitle, Title $newtitle, $pageid, $redirid = 0 ) {
		$oldWikiPage = SMWDIWikiPage::newFromTitle( $oldtitle );
		$newWikiPage = SMWDIWikiPage::newFromTitle( $newtitle );
		$oldExpResource = SMWExporter::getDataItemExpElement( $oldWikiPage );
		$newExpResource = SMWExporter::getDataItemExpElement( $newWikiPage );
		$oldUri = SMWTurtleSerializer::getTurtleNameForExpElement( $oldExpResource );
		$newUri = SMWTurtleSerializer::getTurtleNameForExpElement( $newExpResource );

		$sparqlDatabase = smwfGetSparqlDatabase();
		$sparqlDatabase->insertDelete( "$newUri ?p ?o", "$oldUri ?p ?o" ); /// FIXME this moves properties that are not correct, reparse this page
		$sparqlDatabase->insertDelete( "?s ?p $newUri", "?s ?p $oldUri" );
		if ( $oldtitle->getNamespace() == SMW_NS_PROPERTY ) {
			$sparqlDatabase->insertDelete( "?s $newUri ?o", "?s $oldUri ?o" );
		}

		if ( $redirid != 0 ) { // update/create redirect page data
			/// FIXME reparse this page
		}
		parent::changeTitle( $oldtitle, $newtitle, $pageid, $redirid );
	}

	public function doDataUpdate( SMWSemanticData $data ) {
		parent::doDataUpdate( $data );
		$subjectResource = SMWExporter::getDataItemExpElement( $data->getSubject() );
		$this->deleteSparqlData( $subjectResource );

		$expDataArray = $this->prepareUpdateExpData( $data );

		$turtleSerializer = new SMWTurtleSerializer( true );
		$turtleSerializer->startSerialization();
		foreach ( $expDataArray as $expData ) {
			$turtleSerializer->serializeExpData( $expData );
		}
		$turtleSerializer->finishSerialization();
		$triples = $turtleSerializer->flushContent();
		$prefixes = $turtleSerializer->flushSparqlPrefixes();
		smwfGetSparqlDatabase()->insertData( $triples, $prefixes );
	}

	/**
	 * Prepare an array of SMWExpData elements that should be written to
	 * the SPARQL store, or return null if no update should be performed.
	 * Otherwise, the first SMWExpData object in the array is a translation
	 * of the given input data, but with redirects resolved. 
	 *
	 * @param $data SMWSemanticData object containing the update data
	 */
	protected function prepareUpdateExpData( SMWSemanticData $data ) {
		$expData = SMWExporter::makeExportData( $data );
		$result = array();
		$newExpData = new SMWExpData( $expData->getSubject() );
		$exists = false;
		foreach ( $expData->getProperties() as $propertyResource ) {
			$propertyTarget = $this->getSparqlRedirectTarget( $propertyResource, $exists );
			if ( !$exists && ( $propertyResource->getDataItem() instanceof SMWDIWikiPage ) ) {
				$diWikiPage = $propertyResource->getDataItem();
				if ( ( $diWikiPage !== null ) && !array_key_exists( $diWikiPage->gethash(), $result ) ) {
					$result[$diWikiPage->gethash()] = SMWExporter::makeExportDataForSubject( $diWikiPage, null, true );
				}
			}
			foreach ( $expData->getValues( $propertyResource ) as $expElement ) {
				if ( $expElement instanceof SMWExpNsResource ) {
					$elementTarget = $this->getSparqlRedirectTarget( $expElement, $exists );
					if ( !$exists && ( $expElement->getDataItem() instanceof SMWDIWikiPage ) ) {
						$diWikiPage = $expElement->getDataItem();
						if ( ( $diWikiPage !== null ) && !array_key_exists( $diWikiPage->gethash(), $result ) ) {
							$result[$diWikiPage->gethash()] = SMWExporter::makeExportDataForSubject( $diWikiPage, null, true );
						}
					}
				} else {
					$elementTarget = $expElement;
				}
				$newExpData->addPropertyObjectValue( $propertyTarget, $elementTarget );
			}
		}
		$result[] = $newExpData;
		return $result;
	}

	/**
	 * Find the redirect target of an SMWExpNsResource.
	 * Returns an SMWExpNsResource object the input redirects to,
	 * the input itself if there is no redirect (or it cannot be
	 * used for making a resource with a prefix).
	 *
	 * @param $expNsResource string URI to check
	 * @param $exists boolean that is set to true if $expNsResource is in the store
	 * @return SMWExpNsResource
	 */
	protected function getSparqlRedirectTarget( SMWExpNsResource $expNsResource, &$exists ) {
		$resourceUri = SMWTurtleSerializer::getTurtleNameForExpElement( $expNsResource );
		$rediUri = SMWTurtleSerializer::getTurtleNameForExpElement( SMWExporter::getSpecialPropertyResource( '_REDI' ) );
		$skeyUri = SMWTurtleSerializer::getTurtleNameForExpElement( SMWExporter::getSpecialPropertyResource( '_SKEY' ) );
		$sparqlResult = smwfGetSparqlDatabase()->select( '*', "$resourceUri $skeyUri ?s  OPTIONAL { $resourceUri $skeyUri ?s }", array( 'LIMIT' => 1 ) );

		$firstRow = $sparqlResult->current();
		if ( $firstRow === false ) {
			$exists = false;
			return $expNsResource;
		} elseif ( count( $firstRow ) > 1 && $firstRow[1] !== null ) {
			$exists = true;
			$rediTargetElement = $firstRow[1];
			$rediTargetUri = $rediTargetElement->getUri();
			$wikiNamespace = Exporter::expandUri( '$wiki;' );
			if ( strpos( $rediTargetUri, $wikiNamespace ) === 0 ) {
				return new SMWExpNsResource( substr( $rediTargetUri, 0, strlen( $wikiNamespace ) ) , $wikiNamespace, 'wiki' );
			} else {
				return $expNsResource;
			}
		} else {
			$exists = true;
			return $expNsResource;
		}
	}

	/**
	 * Delete from the SPARQL database all data that is associated with the
	 * given resource.
	 *
	 * @param $expResource SMWExpResource
	 */
	protected function deleteSparqlData( SMWExpResource $expResource ) {
		$resourceUri = SMWTurtleSerializer::getTurtleNameForExpElement( $expResource );
		smwfGetSparqlDatabase()->delete( "$resourceUri ?p ?o", "$resourceUri ?p ?o"  );
	}

}

