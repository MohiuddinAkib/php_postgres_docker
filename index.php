<?php

use DI\ContainerBuilder;
use Doctrine\Common\Inflector\Inflector;
use Pecee\SimpleRouter\SimpleRouter;

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$builder = new ContainerBuilder();
$container = $builder->useAutowiring(true)->build();

$inflector = new Inflector();

// Add our container to simple-router and enable dependency injection
SimpleRouter::enableDependencyInjection($container);

SimpleRouter::setDefaultNamespace('\App\http\controllers');

// Start the routing
SimpleRouter::start();