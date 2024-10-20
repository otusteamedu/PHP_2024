<?php

require_once __DIR__ . '/Client.php';

try {
    $app = new Client();
    $app->run();
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
