<?php

require_once  '../vendor/autoload.php';

use App\EventManager;
use App\RedisClient;

// Инициализация Redis и EventManager
$redisClient = new RedisClient();
$eventManager = new EventManager($redisClient->getClient());

// Обработка HTTP-запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($action) {
        case 'add':
            // Добавление нового события
            $id = uniqid(); // Генерация уникального ID
            $eventManager->addEvent($id, $data['priority'], $data['conditions'], $data['event']);
            echo json_encode(['status' => 'success', 'message' => 'Event added with ID: ' . $id]);
            break;

        case 'clear':
            // Очистка всех событий
            $eventManager->clearEvents();
            echo json_encode(['status' => 'success', 'message' => 'All events cleared.']);
            break;

        case 'query':
            // Поиск наиболее подходящего события
            $result = $eventManager->getBestEvent($data['params']);
            echo json_encode($result);
            break;

        default:
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed. Use POST.']);
}