<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Application\Auth\Exception\TokenInvalidoException;
use App\Application\Auth\Exception\TokenNaoEncontrado;
use App\Application\Handlers\DomainExceptionHandler;
use App\Application\Handlers\InvalidArgumentExceptionHandler;
use App\Application\Handlers\UnauthorizedHandler;
use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require __DIR__ . '/config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();

$invalidArgumentExceptionHandler = new InvalidArgumentExceptionHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory()
);
$domainExceptionHandler = new DomainExceptionHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory()
);
$unauthorizedHandler = new UnauthorizedHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory()
);

$errorMiddleware = $app->addErrorMiddleware(getenv('APP') !== 'prod', true, true);
$errorMiddleware->setErrorHandler( InvalidArgumentException::class, $invalidArgumentExceptionHandler, true);
$errorMiddleware->setErrorHandler( DomainException::class, $domainExceptionHandler, true);
$errorMiddleware->setErrorHandler( TokenNaoEncontrado::class, $unauthorizedHandler);
$errorMiddleware->setErrorHandler( TokenInvalidoException::class, $unauthorizedHandler);

require_once __DIR__ . '/config/routes.php';