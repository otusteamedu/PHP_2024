<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Redis;

class ProcessRequestJob extends Job
{
    protected $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }

    public function handle()
    {
        // Устанавливаем статус запроса в "processing"
        Redis::set('request_status:' . $this->requestId, 'processing');

        // Имитация обработки данных (например, сохранение в базу данных, обработка файлов и т.д.)
        // Здесь можно добавить реальную логику обработки
        sleep(5); // Задержка для имитации времени обработки

        // По завершении обработки меняем статус на "completed"
        Redis::set('request_status:' . $this->requestId, 'completed');
    }
}
