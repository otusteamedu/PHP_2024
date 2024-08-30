<?php
session_start();

if (isset($_GET['set'])) {
    $_SESSION['message'] = 'Эти данные сессии хранятся в Redis.';
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : 'Сессия пуста.';

echo 'Сообщения: ' . htmlspecialchars($message) . PHP_EOL;