<?php

namespace App\Services;

use App\Models\Request;
use Redis;
use RedisException;

class QueueProcessor
{
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect(getenv('REDIS_HOST'), 6379);
    }

    /**
     * @throws RedisException
     */
    public function addToQueue($data): void
    {
        $this->redis->rpush('request_queue', json_encode($data));
    }

    public function processQueue(NotificationService $notification)
    {
        $requestModel = new Request();

        while (true) {
            $data = $this->redis->lpop('request_queue');

            if ($data) {
                $request = json_decode($data, true);

                echo "Обрабатывается запрос для {$request['email']} на даты с {$request['start_date']} по {$request['end_date']}\n";

                $requestModel->updateStatus($request['email'], $request['start_date'], $request['end_date'], 'completed');

                $notification->sendEmail(
                    $request['email'],
                    "Ваша выписка готова",
                    "Ваша выписка за период с {$request['start_date']} по {$request['end_date']} готова."
                );

                $notification->sendTelegram("Запрос для {$request['email']} обработан.");
            }
        }
    }
}
