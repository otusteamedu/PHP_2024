<?php

require_once __DIR__ . '/Server.php';

try {
    $app = new Server();
    $app->run();
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
