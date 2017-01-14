<?php

use Psr\Log\LoggerInterface;

class DatabaseWrapper {
	private $db, $logger;

	public function __construct( LoggerInterface $logger = null ) {
		// @TODO: Actually use this (at all/extensively)
		$this->logger = $logger;

		$sql = new mysqli(
			DB_HOST,
			DB_USER,
			DB_PASS,
			DB_NAME
		);
		$sql->select_db( DB_NAME );
		$this->db = $sql;

		// Get rid of the local object. Just in case.
		unset( $sql );
	}

	public function __deconstruct() {
		$this->db->close();
	}

	/**
	 * Simple wrapper function for... all SQL queries.
	 * Uses the existing database object to save having to open
	 * new ones in every function, potentially duplicating code.
	 *
	 * @param $query - an SQL query.
	 * @return mysqli_result
	 */
	public function doQuery( $query ) {
		return $this->db->query( $query );
	}
}