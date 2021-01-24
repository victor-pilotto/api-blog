<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\ValueObject\PostId;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BuscaPostAction
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

        /** @var PostRepositoryInterface $postRepository */
        $postRepository = $this->container->get(PostRepositoryInterface::class);
        $post           = $postRepository->getById(PostId::fromInt($request->getAttribute('id')));

        $response->getBody()->write(json_encode($post->jsonSerialize(), JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}
