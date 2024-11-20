<?php
declare(strict_types=1);

use App\App;

require_once dirname(__DIR__).'/vendor/autoload.php';

try {
    $app = new App();
    echo $app->run($argv);
} catch (\Exception $e) {
    echo $e->getMessage();
}


