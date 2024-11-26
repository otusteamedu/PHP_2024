<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use AnatolyShilyaev\App\App;

use Redis;

echo (new App())->run();

$redis = new Redis();
$redis->connect('localhost', 6379);
echo $redis->ping();

phpinfo();
