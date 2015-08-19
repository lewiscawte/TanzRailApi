<?php

class APIEncoder {

	public function getSchema( $schema ) {
		global $IP;

		$scheme = $schema['scheme'];
		$version = $schema['version'];

		switch( $scheme ) {
			case 'allCompanyData':
				switch( $version ) {
					case 0.1:
						$schema = "$IP/api/encoder/schemas/scheme-AllCompanyData-0.1.json";
					break;
				}
			break;
			default:
				$schema = new Exception( 'No matching schema' );
			break;
		}

		return $schema;
	}
}