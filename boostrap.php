<?php

require_once __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require __DIR__ . '/config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addErrorMiddleware(getenv('APP') !== 'prod', true, true);

require_once __DIR__ . '/config/routes.php';