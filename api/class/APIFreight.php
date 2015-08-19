<?php

class APIFreight extends APITanzRailBase {

	private function getWorker() {
		return new APIFreightWorker();
	}

	public static function get( $company, $year ) {
		if( $company === 'tazara' && $year === '2011' ) {
			echo 534000;
		} else {
			return null;
		}
	}

	public function getCompanyData( $company ) {
		if( $this->isValidCompany( $company ) ) {
			return $this->getWorker()->getAllCompanyData( $company );
		} else {
			throw new Exception( 'Invalid company' );
		}
	}
}

class APIFreightWorker extends APITanzRailBase {

	public function getAllCompanyData( $company ) {
		$db = $this->getDatabase();

		$query = "SELECT year, data from freight_data WHERE company = '{$company}' ORDER BY YEAR";

		$data = $db->doQuery( $query );

		$x = 0;
		$freightentry = array();

		while ( $entry = $data->fetch_assoc() ) {
			$x++;
			$freightentry[$x] = $entry;
		}

		$data = $this->basicEncode(
			array(
				'scheme' => 'allCompanyData',
				'version' => 0.1
			),
			$freightentry
		);

		return $data;
	}
}