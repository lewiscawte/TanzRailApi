<?php

$app->get( '/api/freight/company/:company', function( $company ) use( $app )  {
	$api = new APIFreight( $company );
	if ( $company === "all" ) {
		echo $api->getAllCompanies();
	} else {
		echo $api->getCompanyData( $company );
	}
} );

$app->get( '/api/freight/company/:company/:year', function( $company, $year ) use( $app )  {
	$api = new APIFreight( $company );
	if ( $company === "all" ) {
		echo $api->getAllCompaniesSingle( $year );
	} else {
		echo $api->getYearlyCompanyStat( $company, $year );
	}
} );

$app->get( '/api/freight/year/:year', function( $year ) use( $app ) {
	$app->redirect( "/api/freight/company/all/{$year}" );
} );

$app->get( '/api/freight/year/:year/:company', function( $year, $company ) use( $app ) {
	$app->redirect( "/api/freight/company/{$company}/{$year}" );
} );