<?php

namespace VladimirGrinko\Rabbit\App\Controller;

use VladimirGrinko\Rabbit\App\Queue\QueueInterface;

class RequestController
{
    private QueueInterface $queue;

    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;
    }

    public function handleRequest(array $request): string
    {
        $startDate = $request['start_date'] ?? null;
        $endDate = $request['end_date'] ?? null;
        $notif = $request['notif_address'] ?? null;

        if (!$startDate || !$endDate) {
            throw new \Exception("Некорректные даты");
        }

        if (!filter_var($notif, FILTER_VALIDATE_EMAIL) && !filter_var($notif, FILTER_VALIDATE_INT)) {
            throw new \Exception("Некорректный способ получения");
        }

        $this->queue->sendMessage([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'notif' => $notif,
        ]);

        return "Ваш запрос принят в обработку. Ожидайте уведомления.";
    }
}
