<?php

use App\Application\Auth\AuthenticationInterface;
use App\Application\Auth\JWT\Authentication;
use App\Domain\Repository\PostRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\AtualizarPost;
use App\Domain\Service\CadastrarPost;
use App\Domain\Service\CadastrarUser;
use App\Domain\Service\ExcluirUser;
use App\Domain\Service\LocalizarUser;
use App\Infrastructure\Doctrine\PostRepository;
use App\Infrastructure\Doctrine\UserRepository;
use DI\Container;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

/** @var Container */
$container = new Container();

require_once __DIR__ . '/database.php';

$container->set(AuthenticationInterface::class, static function (Container $container) {
    return new Authentication(
        Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText(getenv('AUTH_TOKEN_SIGNER_KEY'))),
        $container->get(UserRepositoryInterface::class)
    );
});


// Services
$container->set(CadastrarUser::class, static function (Container $container) {
    return new CadastrarUser($container->get(UserRepositoryInterface::class));
});
$container->set(LocalizarUser::class, static function (Container $container) {
    return new LocalizarUser($container->get(UserRepositoryInterface::class));
});
$container->set(ExcluirUser::class, static function (Container $container) {
    return new ExcluirUser($container->get(UserRepositoryInterface::class));
});
$container->set(CadastrarPost::class, static function (Container $container) {
    return new CadastrarPost(
        $container->get(PostRepositoryInterface::class)
    );
});
$container->set(AtualizarPost::class, static function (Container $container) {
    return new AtualizarPost(
        $container->get(PostRepositoryInterface::class)
    );
});

// Repository
$container->set(UserRepositoryInterface::class, static function (Container $container) {
    return new UserRepository($container->get('doctrine'));
});
$container->set(PostRepositoryInterface::class, static function (Container $container) {
    return new PostRepository($container->get('doctrine'));
});


return $container;
