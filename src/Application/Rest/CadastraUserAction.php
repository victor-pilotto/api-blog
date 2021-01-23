<?php

namespace App\Application\Rest;

use App\Domain\DTO\CadastraUserDTO;
use App\Domain\Service\CadastrarUser;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CadastraUserAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();

        $cadastraUserDTO = CadastraUserDTO::fromArray($params);

        /** @var CadastrarUser $cadastrarUser */
        $cadastrarUser = $this->container->get(CadastrarUser::class);
        $user = $cadastrarUser->cadastrar($cadastraUserDTO);

        $response->getBody()->write('Hello World');
        return $response;
    }
}