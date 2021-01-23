<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Domain\DTO\CadastraUserDTO;
use App\Domain\Service\CadastrarUser;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class CadastraUserAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();

        $cadastraUserDto = CadastraUserDTO::fromArray((array)$params);

        /** @var CadastrarUser $cadastrarUser */
        $cadastrarUser = $this->container->get(CadastrarUser::class);
        $user          = $cadastrarUser->cadastrar($cadastraUserDto);

        /** @var AuthenticationInterface $authentication */
        $authentication = $this->container->get(AuthenticationInterface::class);
        $token          = $authentication->generateToken($user);

        $response->getBody()->write(json_encode(['token' => $token], JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}
