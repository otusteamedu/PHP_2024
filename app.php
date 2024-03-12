<?php

require __DIR__ . '/vendor/autoload.php';

use Src\Services\ChatService;

try {
    $chatService = new ChatService('server');
    $chatService->run();
} catch (\Throwable $th) {
    throw $th;
}