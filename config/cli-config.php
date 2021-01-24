<?php

use App\Domain\Entity\Post;
use App\Domain\Entity\User;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../bootstrap.php';

$entityManager = $container->get('doctrine');

$entityManager->getClassMetadata(User::class);
$entityManager->getClassMetadata(Post::class);

return ConsoleRunner::createHelperSet($entityManager);
