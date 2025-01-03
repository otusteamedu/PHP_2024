<?php

use VladimirGrinko\Rabbit\App\{
    Controller\RequestController,
    Queue\RabbitMQService
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queueService = new RabbitMQService(getenv('RABBIT_HOST'), getenv('RABBIT_PORT'), getenv('RABBIT_USER'), getenv('RABBIT_PASSWORD'), getenv('RABBIT_QUEUE_NAME'));
    $requestController = new RequestController($queueService);
    echo $requestController->handleRequest($_POST);
} else {
    echo '<form method="POST" action="">
        Начало: <input type="date" name="start_date" required><br>
        Конец: <input type="date" name="end_date" required><br>
        Email или ваш TelegramId: <input name="notif_address" required><br>
        <input type="submit" value="Сформировать">
    </form>';
}
