<?php
declare(strict_types=1);

use App\Infrastructure\Controller\Controller;

require_once(dirname(__DIR__).'/vendor/autoload.php');

try {
    $app = new Controller();
    $app->run($argv[1]);
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}

