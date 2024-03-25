<?php

declare(strict_types=1);

session_start();

echo 'Контейнер: ' . $_SERVER['SERVER_ADDR'] . PHP_EOL;

// Проверяем, установлено ли значение в сессии
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

$_SESSION['counter'] += 1;

echo "Количество обновление: " . $_SESSION['counter'] . PHP_EOL;
