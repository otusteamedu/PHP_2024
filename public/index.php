<?php

use Bramus\Router\Router;

require '../vendor/autoload.php';
require '../routes/web.php';

$router = new Router();

require __DIR__ . '/../routes/web.php';

$router->run();
