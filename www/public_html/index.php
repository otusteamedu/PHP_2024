<?php
declare(strict_types=1);

use Builov\RedisApp\AppController;

require __DIR__ . '/../vendor/autoload.php';

$app = new AppController();
$app->run();
