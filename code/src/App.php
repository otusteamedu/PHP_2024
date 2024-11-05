<?php

declare(strict_types=1);

namespace Naimushina\EventManager;

use Exception;
use Generator;

class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run(): Generator
    {
        $storage = new RedisStorage();
        $eventManager = new EventManager($storage);
        $consoleManager = new GetParamsService();
        $command = $_SERVER['argv'][1] ?? null;
        return match ($command) {
            'set' => $this->addEvent($consoleManager, $eventManager),
            'get' => $this->getEvent($consoleManager, $eventManager),
            'del' => $this->deleteAll($eventManager),
            default => throw new Exception('Unknown command "' . $command . '"')
        };
    }

    /**
     * Добавляем событие в систему хранения
     * @param GetParamsService $consoleManager
     * @param EventManager $eventManager
     * @return Generator
     */
    private function addEvent(GetParamsService $consoleManager, EventManager $eventManager): Generator
    {
        $priority = $consoleManager->getPriorityInfo();
        $conditions = $consoleManager->getParamsInfo();
        $event = $consoleManager->getEventInfo();
        $eventManager->addEvent($priority, $conditions, $event);
        yield 'Событие успешно добавлено' . PHP_EOL;
    }

    /**
     * Получаем наиболее подходящее событие по запросу пользователя
     * @param GetParamsService $consoleManager
     * @param EventManager $eventManager
     * @return Generator
     */
    private function getEvent(GetParamsService $consoleManager, EventManager $eventManager): Generator
    {
        $conditions = $consoleManager->getParamsInfo();
        $events = $eventManager->getByParams($conditions);
        yield 'Количество подходящих событий ' . count($events) . PHP_EOL;
        if (count($events)) {
            yield 'наиболее подходящее событие: ' . $events[0]->data . PHP_EOL;
        }
    }

    /**
     * Очищаем все доступные события
     * @param EventManager $eventManager
     * @return Generator
     */
    private function deleteAll(EventManager $eventManager): Generator
    {
        $eventManager->deleteAll();
        yield 'Все события успешно удалены' . PHP_EOL;
    }
}
