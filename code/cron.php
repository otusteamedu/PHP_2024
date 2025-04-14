<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Services\ReceiverRabbitMQ;

require_once('vendor/autoload.php');

define('ROOT', dirname(__FILE__));

try {

    $objectCron = new ReceiverRabbitMQ();
    $objectCron->execute();

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}