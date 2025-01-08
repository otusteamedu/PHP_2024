<?php

namespace VladimirGrinko\Rabbit\View;

use VladimirGrinko\Rabbit\App\{
    Controller\RequestController,
    Queue\RabbitMQService
};

class View
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->showForm();
        } else {
            $this->handleRequest($_POST);
        }
    }

    private function showForm()
    {
        echo '<form method="POST" action="">
        Начало: <input type="date" name="start_date" required><br>
        Конец: <input type="date" name="end_date" required><br>
        Email или ваш TelegramId: <input name="notif_address" required><br>
        <input type="submit" value="Сформировать">
        </form>';
    }

    private function handleRequest(array $arPost)
    {
        $queueService = new RabbitMQService(getenv('RABBIT_HOST'), getenv('RABBIT_PORT'), getenv('RABBIT_USER'), getenv('RABBIT_PASSWORD'), getenv('RABBIT_QUEUE_NAME'));
        $requestController = new RequestController($queueService);
        echo $requestController->handleRequest($arPost);
    }
}
