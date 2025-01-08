<?php

namespace VladimirGrinko\Rabbit\Client;

use VladimirGrinko\Rabbit\App\{
    Queue\RabbitMQService,
    Service\TelegramNotification,
    Service\EmailNotification,
    Service\TaskProcessor
};

class Worker
{
    public function run()
    {
        $queueService = new RabbitMQService(getenv('RABBIT_HOST'), getenv('RABBIT_PORT'), getenv('RABBIT_USER'), getenv('RABBIT_PASSWORD'), getenv('RABBIT_QUEUE_NAME'));
        $taskProcessor = new TaskProcessor();

        $queueService->consumeMessages(function ($task) use ($taskProcessor) {
            $taskResult = $taskProcessor->processTask($task);

            $subject = "Ваша банковская выписка готова";
            $message = "Банковская выписка с {$task['start_date']} по {$task['end_date']}";
            $message .= "Результат выписки: {$taskResult}";

            if (filter_var($task['notif'], FILTER_VALIDATE_EMAIL) !== false) {
                $notification = new EmailNotification();
            } elseif (filter_var($task['notif'], FILTER_VALIDATE_INT) !== false) {
                $notification = new TelegramNotification(getenv('TELEGRAM_BOT_TOKEN'));
            } else {
                throw new \Exception("Некорректный способ получения");
            }

            $notification->send($task['notif'], $subject, $message);

            echo 'Результат отправлен' . PHP_EOL;
        });
    }
}
