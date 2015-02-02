<?php

session_start();

require __DIR__.'/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = [
    "model",
];
$isDevMode = true;

// the connection configuration
$dbParams = require __DIR__.'/config/config.php';

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

return EntityManager::create($dbParams, $config);
