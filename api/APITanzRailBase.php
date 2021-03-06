<?php

class APITanzRailBase {

	public function getDatabase() {
		return new DatabaseWrapper();
	}

	public function basicEncode( array $schema, $data ) {
		// @TODO: Write a better encoder to facilitate schema based JSON outputs
		// $enc = new APIEncoder();
		// $schema = $enc->getSchema( $schema );
		// return new JsonBasicEncoder( $schema, $data );

		$enc = json_encode( $data, JSON_PRETTY_PRINT );
		return $enc;
	}

	public function isValidCompany( $company ) {
		global $tzrValidCompanies;

		$company = htmlspecialchars( strtolower( $company ) );
		$company = $this->mapCompanyAliases( $company );

		if ( array_key_exists( $company, $tzrValidCompanies ) ) {
			return true;
		} else {
			return new Exception( 'Company does not exist' );
		}
	}

	protected function mapCompanyAliases( $input ) {
		switch( $input ) {
			case 'trl':
			case 'tanzaniarailcorporation':
			case 'tanzaniaraillimited':
			case 'trc':
				return 'trl';
			break;

			case 'tanzaniazambia':
			case 'tazararailway':
			case 'uhururailway':
			case 'uhuru':
			case 'tanzam':
			case 'tanzamrailway':
				return 'tazara';
			break;

			case 'all':
				return 'all';
			break;

			default:
				return $input;
			break;
		}
	}
}