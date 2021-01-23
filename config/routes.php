<?php

use App\Application\Rest\CadastraUserAction;
use App\Application\Middleware;
use DI\Container;

/** @var Container $container */
$container = $app->getContainer();

$app->add(new Middleware\JsonBodyParserMiddleware());

$app->post('/user', new CadastraUserAction($container));