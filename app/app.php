<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Kiryao\Sockchat\App;

 try {
     $app = new App();
     $app->run();
 } catch (Throwable $e) {
     echo 'An error occurred when initializing the application: ' . $e->getMessage();
 }

//$configSocket = (new ConfigProvider())->load('socket');
//$config = new SocketConfig($configSocket);
//echo $config->getDomain();
