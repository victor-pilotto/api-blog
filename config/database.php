
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container->set('doctrine', static function () {
    $paths = [__DIR__ . '/../src/'];
    $isDevMode = $_ENV['APP'] !== 'prod';

    $config = Setup::createAnnotationMetadataConfiguration(
        $paths,
        $isDevMode,
        null,
        null,
        false
    );

    $connectionParams = [
        'dbname'   => $_ENV['DB_NAME'],
        'user'     => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'host'     => $_ENV['DB_HOST'],
        'port'     => $_ENV['DB_PORT'],
        'driver'   => $_ENV['DB_DRIVER'],
        'charset'  => 'utf8'
    ];

    require_once __DIR__ . '/types/doctrine-types.php';

    return EntityManager::create($connectionParams, $config);
});