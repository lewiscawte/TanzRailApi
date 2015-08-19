<?php

$app->get( '/api/freight/company/:company', function( $company ) use( $app )  {
	$api = new APIFreight( $company );
	echo $api->getCompanyData( $company );
} );

$app->get( '/api/freight/company/:company/:year', function( $company, $year ) use( $app )  {
	$api = new APIFreight( $company );
	echo $api->getYearlyCompanyStat( $company, $year );
} );
