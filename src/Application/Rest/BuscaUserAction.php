<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\UserId;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BuscaUserAction
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

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->container->get(UserRepositoryInterface::class);
        $user           = $userRepository->getById(UserId::fromInt($request->getAttribute('id')));

        $response->getBody()->write(json_encode($user->jsonSerialize(), JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}
