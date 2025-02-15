<?php

use SlavaMakhov\OtusQueueApp\Services\RabbitMQService;

$queueService = new RabbitMQService();
$queueService->consumeMessages(function ($task) {

    try {
        $message = "Банковская выписка с {$task['start_date']} по {$task['end_date']}";

        echo 'Результат: ' . $message . PHP_EOL;
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
});
