<?php

declare(strict_types=1);

namespace App;

use App\Storages\RedisEventStorage;

class App
{
    public static function run(): void
    {
        $storage = new EventStorage(new RedisEventStorage());

        // Добавление событий
        $storage->addEvent(1000, ['param1' => 1], 'events::event::first');
        $storage->addEvent(2000, ['param1' => 2, 'param2' => 2], 'events::event::second');
        $storage->addEvent(3000, ['param1' => 1, 'param2' => 2], 'events::event::third');

        // Запрос пользователя
        $params = ['param1' => 1, 'param2' => 2];
        $event = $storage->getEventByParams($params);
        if ($event) {
            echo 'Найдено событие: ' . json_encode($event['event']) . PHP_EOL;
        } else {
            echo 'Событие не найдено.' . PHP_EOL;
        }

        // Очистка всех событий
        $storage->clearEvents();
    }
}
