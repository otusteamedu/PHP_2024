<?php

namespace App\Infrastructure\Middleware;

use App\Infrastructure\Middleware\RequestHandler;
use Illuminate\Http\Request;

class LoadLimitRequestHandler extends RequestHandler
{
    private int $maxRequests = 10; // Максимальное количество запросов в минуту
    private int $interval = 60;    // Интервал в секундах
    private array $requests = [];  // массив для хранения таймстэмпов запросов

    public function handle(Request $request): void
    {
        // Получаем текущий timestamp
        $currentTime = time();

        // файл для хранения запросов за наблюдаемый интервал
        $counterFile = sys_get_temp_dir() . '/' . 'counter.txt';

        // считываем из файла сохраненный массив запросов
        if (file_exists($counterFile)) {
            $this->requests = unserialize(file_get_contents($counterFile));
        }

        // Очищаем устаревшие запросы
        $this->cleanup($currentTime);

        // Проверяем лимит
        if (count($this->requests) >= $this->maxRequests) {
            throw new \Exception('Превышен лимит запросов', 429);
        }

        // Добавляем текущий запрос
        $this->requests[] = $currentTime;
//        var_dump(count($this->requests));

        // записываем в файл массив
        file_put_contents($counterFile, serialize($this->requests));

        parent::handle($request);
    }

    private function cleanup($currentTime): void
    {
        // Удаляем запросы старше минуты
        $this->requests = array_filter($this->requests, function ($timestamp) use ($currentTime) {
            return $currentTime - $timestamp <= $this->interval;
        });
    }
}
