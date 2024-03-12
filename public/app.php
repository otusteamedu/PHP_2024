<?php

declare(strict_types=1);

use IlyaPlotnikov\SocketChat\ChatService;

require __DIR__ . '/../vendor/autoload.php';

try {
    $chatService = new ChatService('server');
    $chatService->run();
} catch (\Throwable $th) {
    //throw $th;
}