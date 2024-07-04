<?php
declare(strict_types=1);


use App\Infrastructure\Http\Controller;

require_once dirname(__DIR__, 2) .'/vendor/autoload.php';


$controller = new Controller();
$res = $controller->run();

print_r($res);
