<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../bootstrap.php';

$entityManager = $container->get('doctrine');

$entityManager->getClassMetadata('App\Domain\Entity\User');
$entityManager->getClassMetadata('App\Domain\Entity\Post');

return ConsoleRunner::createHelperSet($entityManager);
