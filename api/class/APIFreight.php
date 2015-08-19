<?php

class APIFreight extends APITanzRailBase {

	public function __construct( $company ) {
		if( !$this->isValidCompany( $company ) ) {
			throw new Exception( 'Invalid company' );
		}
	}

	private function getWorker() {
		return new APIFreightWorker();
	}

	public function getCompanyData( $company ) {
		return $this->getWorker()->getAllCompanyData( $company );
	}

	public function getYearlyCompanyStat( $company, $year ) {
		return $this->getWorker()->getCompanyYearData( $company, $year );
	}
}

class APIFreightWorker extends APITanzRailBase {

	public function getAllCompanyData( $company ) {
		$db = $this->getDatabase();

		$company = $this->mapCompanyAliases( $company );

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

	public function getCompanyYearData( $company, $year ) {
		// @TODO: Reduce code duplication between APIFreightWorker::getCompanyYearData
		// @TODO:	and APIFreightWorker::getAllCompanyData.
		$db = $this->getDatabase();

		$company = $this->mapCompanyAliases( $company );

		$query = "SELECT year, data from freight_data WHERE company = '{$company}' AND year = '{$year}'";

		$data = $db->doQuery( $query )->fetch_assoc();

		$data = $this->basicEncode(
			array(
				'scheme' => 'companyAtYear',
				'version' => 0.1
			),
			$data
		);

		return $data;
	}
}