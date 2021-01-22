<?php

use App\Application\Rest\CadastraUserAction;
use DI\Container;

/** @var Container $container */
$container = $app->getContainer();

$app->post('/user', new CadastraUserAction($container));