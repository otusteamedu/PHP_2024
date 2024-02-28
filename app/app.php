<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Kiryao\Sockchat\Config\Providers\SocketPathConfigProvider;
use Kiryao\Sockchat\Config\Providers\SocketConfigProvider;
use Kiryao\Sockchat\Config\Providers\ChatConfigProvider;
use Kiryao\Sockchat\Chat\IO\IOManager;
use Kiryao\Sockchat\App\App;

$configPath = __DIR__ . '/config/config.ini';
$socketConfig = (new SocketConfigProvider($configPath, 'socket_constants'))->load();
$socketPathConfig = (new SocketPathConfigProvider($configPath, 'socket_path'))->load();
$chatConfig = (new ChatConfigProvider($configPath, 'chat'))->load();

$ioManager = new IOManager();

try {
    $app = new App($socketConfig, $socketPathConfig, $chatConfig, $ioManager);
    $app->run();
} catch (Throwable $e) {
    echo 'An error occurred when initializing the application: ' . $e->getMessage();
}
