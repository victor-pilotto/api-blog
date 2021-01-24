<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Domain\DTO\BuscaPostPorFiltroDTO;
use App\Domain\Entity\Post;
use App\Domain\Repository\PostRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BuscaPostPorFiltroAction
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $buscaPostPorFiltroDto = BuscaPostPorFiltroDTO::fromArray((array) $request->getQueryParams());

        /** @var AuthenticationInterface $authentication */
        $authentication = $this->container->get(AuthenticationInterface::class);
        $authentication->authenticate(HeaderToken::get());

        /** @var PostRepositoryInterface $postRepository */
        $postRepository = $this->container->get(PostRepositoryInterface::class);
        $posts          = $postRepository->findByBuscaPostPorFiltroDto($buscaPostPorFiltroDto);

        $posts = array_map(static fn (Post $post) => $post->jsonSerialize(), $posts);

        $response->getBody()->write(json_encode($posts, JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}
