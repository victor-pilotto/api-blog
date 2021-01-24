<?php

use App\Application\Auth\Exception\TokenInvalidoException;
use App\Application\Auth\Exception\TokenNaoEncontradoException;
use App\Application\Handlers\DomainExceptionHandler;
use App\Application\Handlers\InvalidArgumentExceptionHandler;
use App\Application\Handlers\NotFoundHandler;
use App\Application\Handlers\UnauthorizedHandler;
use App\Domain\Exception\PostNaoExisteException;
use App\Domain\Exception\UserNaoAutorizadoException;
use App\Domain\Exception\UserNaoExisteException;

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
$notFoundHandler = new NotFoundHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory()
);

$errorMiddleware = $app->addErrorMiddleware(getenv('APP') !== 'prod', true, true);

$errorMiddleware->setErrorHandler( InvalidArgumentException::class, $invalidArgumentExceptionHandler, true);
$errorMiddleware->setErrorHandler( DomainException::class, $domainExceptionHandler, true);
$errorMiddleware->setErrorHandler([UserNaoExisteException::class, PostNaoExisteException::class], $notFoundHandler);
$errorMiddleware->setErrorHandler([
    TokenNaoEncontradoException::class,
    UserNaoAutorizadoException::class,
    TokenInvalidoException::class
], $unauthorizedHandler);

