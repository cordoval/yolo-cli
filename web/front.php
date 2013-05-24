<?php

use Symfony\Component\HttpFoundation\Request;

if (!isset($env)) {
    http_response_code(503);
    echo 'Front controller must have environment configured.';
    exit;
}

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/Cli/app.php';
/** @var $kernel \Symfony\Component\HttpKernel\HttpKernel */
$kernel = $app->getHttpKernel();

if ($argc <= 1) {
    throw new \Exception('Cli app needs arguments');
}

$request = Request::create($argv[1], "GET", array_slice($argv, 2));
$response = $kernel->handle($request);

echo $response->getContent();
