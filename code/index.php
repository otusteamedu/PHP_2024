<?php
declare(strict_types=1);

use App\DbManager;

require_once dirname(__DIR__).'/vendor/autoload.php';


try {

    $app = new DbManager;
    var_dump($app->run($argv));

} catch (Exception $exception) {
    echo $exception->getMessage();
}