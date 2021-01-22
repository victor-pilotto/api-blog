
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container->set('doctrine', static function () {
    $paths = [__DIR__ . '/../src/'];
    $isDevMode = true;

    $config = Setup::createAnnotationMetadataConfiguration(
        $paths,
        $isDevMode,
        null,
        null,
        false
    );

    $connectionParams = [
        'dbname'   => getenv('DB_NAME'),
        'user'     => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'driver'   => getenv('DB_DRIVER'),
        'charset'  => 'utf8'
    ];

    return EntityManager::create($connectionParams, $config);
});