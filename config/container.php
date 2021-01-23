<?php

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\CadastrarUser;
use App\Infrastructure\Doctrine\UserRepository;
use DI\Container;

/** @var Container */
$container = new Container();

require_once __DIR__ . '/database.php';

// Services
$container->set(CadastrarUser::class, static function (Container $container) {
    return new CadastrarUser($container->get(UserRepositoryInterface::class));
});

// Repository
$container->set(UserRepositoryInterface::class, static function (Container $container) {
    return new UserRepository($container->get('doctrine'));
});


return $container;
