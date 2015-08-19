<?php

require "$IP/vendor/Slim/Slim/Slim.php";
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

require_once "$IP/api/handlers/FreightAPI.php";

$app->contentType( 'application/json' );
$app->run();