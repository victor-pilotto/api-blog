<?php

namespace App\Application\Rest;

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\HeaderToken;
use App\Application\Presenter\SimplePostPresenter;
use App\Domain\DTO\AtualizaDTO;
use App\Domain\Service\AtualizarPost;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AtualizaPostAction
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
        $userId = $authentication->authenticate(HeaderToken::get());

        $params = $request->getParsedBody();
        $postDTO = AtualizaDTO::fromArray(array_merge(
            $params,
            ['userId' => $userId, 'postId' => (int)$request->getAttribute('id')]
        ));

        /** @var AtualizarPost $atualizarPost */
        $atualizarPost = $this->container->get(AtualizarPost::class);
        $post = $atualizarPost->atualizar($postDTO);

        $response->getBody()->write(json_encode(SimplePostPresenter::format($post), JSON_THROW_ON_ERROR));
        return $response
            ->withStatus(200);
    }
}