<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Domain\DTO\LoginDTO;
use App\Domain\Service\LocalizarUser;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();

        $loginDto = LoginDTO::fromArray((array) $params);

        /** @var LocalizarUser $localizarUser */
        $localizarUser = $this->container->get(LocalizarUser::class);
        $user          = $localizarUser->localizar($loginDto);

        /** @var AuthenticationInterface $authentication */
        $authentication = $this->container->get(AuthenticationInterface::class);
        $token          = $authentication->generateToken($user);

        $response->getBody()->write(json_encode(['token' => $token], JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}
