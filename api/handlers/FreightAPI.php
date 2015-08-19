<?php

$app->get( '/api/freight/:company', function( $company ) use( $app )  {
	$api = new APIFreight();
	echo $api->getCompanyData( $company );
} );