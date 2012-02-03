<?php

/**
 * Overrides and extends core's list=categorymembers query module
 */
class ApiQueryCategoryMembers_GeoData extends ApiQueryCategoryMembers {
	private $useIndex = false, $alreadyAltered;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	protected function select( $method, $extraQuery = array() ) {
		if ( !$this->alreadyAltered ) {
			$params = $this->extractRequestParams();

			$this->requireOnlyOneParameter( $params, 'withcoordinates', 'withoutcoordinates' );

			list( $tables, $fields, $joins, $options, $where ) = 
				GeoDataQueryExtender::alterQuery( $params, 'cl_from', $this->useIndex );
			$this->addTables( $tables );
			$this->addFields( $fields );
			$this->addJoinConds( $joins );
			foreach ( $options as $name => $value ) {
				parent::addOption( $name, $value );
			}
			$this->addWhere( $where );
			$this->alreadyAltered = true;
		}

		return parent::select( __METHOD__, $extraQuery );
	}

	/**
	 * Only allow USE INDEX if not joining, otherwise it errors out
	 */
	protected function addOption( $name, $value = null ) {
		if ( $name == 'USE INDEX' ) {
			$this->useIndex = $value;
		} else {
			parent::addOption( $name, $value );
		}
	}

	public function getDescription() {
		return 'Lists pages with or without coordinates in a given category';
	}

	public function getAllowedParams() {
		return array_merge( parent::getAllowedParams(), GeoDataQueryExtender::getAllowedParams() );
	}
}
