<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusRedisApp\Events;

use SlavaMakhov\OtusRedisApp\Services\RedisServiceInterface;

class EventManager
{
    /** @var RedisServiceInterface */
    private RedisServiceInterface $redisService;

    public function __construct(RedisServiceInterface $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * Метод добавляет событие в Redis
     *
     * @param array $event
     *
     * @return string
     */
    public function addEvent(array $event): string
    {
        $eventId = uniqid();
        $this->redisService->set("event:" . $eventId, $event);

        return "Добавлено событие с ID: " . $eventId . PHP_EOL;
    }

    /**
     * Метод выполняет поиск лучших совпадений в Redis
     *
     * @param array $params
     *
     * @return string
     */
    public function searchEvents(array $params): string
    {
        $bestEvent = null;
        $message = "Событие не найдено." . PHP_EOL;
        $events = $this->redisService->getAll("event:*");

        // Перебираем все события из Redis и входящие параметры для поиска
        foreach ($events as $event) {
            $conditionsMet = true;
            foreach ($event['conditions'] as $condition => $value) {
                // Проверяем каждый входящий параметр и сравниваем с теми, что лежат в Redis.
                // Если хоть одного совпадения нет, то переходим к следующему $event
                if (!isset($params[$condition]) || $params[$condition] != $value) {
                    $conditionsMet = false;
                    break;
                }
            }

            // Если есть совпадения, то проверяем приоритетность, и выбираем тот,
            // у которого приоритет выше
            if ($conditionsMet) {
                if (!$bestEvent || $event['priority'] > $bestEvent['priority']) {
                    $bestEvent = $event;
                }
            }
        }

        if ($bestEvent) {
            $message = "Лучшее событие: " . json_encode($bestEvent) . PHP_EOL;
        }

        return $message;
    }

    /**
     * Метод удаляет все события из Redis
     *
     * @return string
     */
    public function clearEvents(): string
    {
        $this->redisService->clear("event:*");

        return "Все события удалены." . PHP_EOL;
    }
}
