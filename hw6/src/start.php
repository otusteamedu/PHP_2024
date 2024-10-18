<?php

require_once __DIR__ . '/App.php'; // Подключаем класс App

try {
    $app = new App();  // Создаем экземпляр класса App
    $app->run();       // Запускаем метод run
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
