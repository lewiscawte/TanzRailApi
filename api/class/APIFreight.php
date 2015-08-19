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

	public function getAllCompanies() {
		return $this->getWorker()->getAllCompanies();
	}

	public function getAllCompaniesSingle( $year ) {
		return $this->getWorker()->getAllCompaniesSingle( $year );
	}
}

class APIFreightWorker extends APITanzRailBase {

	public function getAllCompanyData( $company ) {
		$db = $this->getDatabase();

		$company = $this->mapCompanyAliases( $company );

		$query = "SELECT year, data from freight_data WHERE company = '{$company}' ORDER BY YEAR";

		$data = $db->doQuery( $query );

		$freightentry = array();

		while ( $entry = $data->fetch_assoc() ) {
			$freightentry[$entry['year']] = $entry['data'];
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

	public function getAllCompanies() {
		$db = $this->getDatabase();

		$query = "SELECT * from freight_data ORDER BY year, company";

		$data = $db->doQuery( $query );

		$year = array();
		$years = array();
		$newYears = array();

		while ( $entry = $data->fetch_assoc() ) {
			$years[] = $year[$entry['year']] = $entry;
		}

		foreach( $years as $oneyear ) {
			$curryear = $oneyear['year'];
			$company = $oneyear['company'];

			$newYears[$curryear][$company] = $oneyear['data'];
		}

		$data = $this->basicEncode(
			array(
				'scheme' => 'someschema',
				'version' => 0.1
			),
			$newYears
		);

		return $data;
	}

	public function getAllCompaniesSingle( $year ) {
		$db = $this->getDatabase();

		$query = "SELECT company, data from freight_data WHERE year = {$year} ORDER BY company";

		$data = $db->doQuery( $query );

		$year = array();

		while ( $entry = $data->fetch_assoc() ) {
			$year[$entry['company']] = $entry['data'];
		}

		$data = $this->basicEncode(
			array(
				'scheme' => 'someschema',
				'version' => 0.1
			),
			$year
		);

		return $data;
	}
}