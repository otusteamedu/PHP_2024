<?php
declare(strict_types=1);

use App\Infrastructure\Routes\Router\Route;
use App\Infrastructure\Routes\Router\Router;

require_once dirname(__DIR__, 2) .'/vendor/autoload.php';


//$routes = new Router();
//$res = $routes->runController();

$routes = new Route();
$res = $routes->runController();

print_r($res);
