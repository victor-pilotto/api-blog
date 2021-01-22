<?php

use DI\Container;

/** @var Container */
$container = new Container();

require_once __DIR__ . '/../config/database.php';

return $container;
