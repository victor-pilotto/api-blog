<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\ExcluirUser;
use App\Domain\ValueObject\UserId;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExcluiUserAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /** @var AuthenticationInterface $authentication */
        $authentication = $this->container->get(AuthenticationInterface::class);
        $authentication->authenticate(HeaderToken::get());

        /** @var ExcluirUser $excluirUser */
        $excluirUser = $this->container->get(ExcluirUser::class);
        $excluirUser->excluir(UserId::fromInt($request->getAttribute('id')));

        return $response
            ->withStatus(204);
    }
}