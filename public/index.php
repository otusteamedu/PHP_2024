<?php

declare(strict_types=1);

use App\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = Container::build();

AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/../config/routes.php')($app, $container);

$app->run();
