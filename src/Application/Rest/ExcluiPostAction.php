<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Domain\DTO\ExcluiPostDTO;
use App\Domain\Service\ExcluirPost;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExcluiPostAction
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
        $user           = $authentication->authenticate(HeaderToken::get());

        $excluiDto = ExcluiPostDTO::fromArray([
            'user'   => $user,
            'postId' => (int) $request->getAttribute('id'),
        ]);

        /** @var ExcluirPost $excluirPost */
        $excluirPost = $this->container->get(ExcluirPost::class);
        $excluirPost->excluir($excluiDto);

        return $response
            ->withStatus(204);
    }
}
