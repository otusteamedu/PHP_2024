<?php

namespace Naimushina\EventManager;

use Exception;
use Predis\Client;
use Throwable;

class RedisStorage implements StorageInterface
{
    /**
     * Строка с ключом для хранения информации о событиях в редис
     */
    const EVENT_KEY = 'events';
    /**
     * @var Client
     */
    private Client $redis;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->testRedisConnection();
    }

    /**
     * Очищаем все ключи содержащие ключ событий в редисе
     * @throws Exception
     */
    public function deleteAll(): int
    {
        try {
            $redisKey = self::EVENT_KEY;
            $keysForEvents = $this->redis->keys("$redisKey*");
            return count($keysForEvents) ? $this->redis->del($keysForEvents) : 0;
        } catch (Exception $exception) {
            throw new Exception('Ошибка при удалении событий: ' . $exception->getMessage());
        }

    }

    /**
     * Добавляем информацию о событии в редис
     * @throws Exception
     */
    public function addEvent(Event $event): bool
    {
        $redisKey = self::EVENT_KEY;
        $eventId = $this->getId($redisKey);
        try {
            $this->storeEventInfo($event, $redisKey, $eventId);
            $this->addEventParams($event->conditions, $redisKey, $eventId);
            return true;
        } catch (Exception $exception) {
            $this->revertAddEvent($redisKey, $eventId);
            throw new Exception('Ошибка при добавлении события: ' . $exception->getMessage());
        }
    }

    /**
     * Получаем id событий, которые удовлетворяют переданным параметрам
     * @param array $params
     * @return array
     */
    public function getEventsForParams(array $params): array
    {
        $keys = [];
        $eventIds = [];
        $redisKey = self::EVENT_KEY;
        foreach ($params as $param => $paramValue) {
            $valuesForParam = $this->redis->hgetall("$redisKey:params:$param");
            $eventIds = [...array_keys($valuesForParam), ...$eventIds];
            $keys[$param] = $valuesForParam;

        }
        $eventIds = array_unique($eventIds);
        foreach ($params as $param => $paramValue) {
            $valuesForParam = $keys[$param] ?? [];

            foreach ($valuesForParam as $eventId => $eventValue) {
                if ($eventValue !== strval($paramValue)) {
                    $eventIds = array_diff($eventIds, [$eventId]);
                }
            }
        }

        return $eventIds;
    }

    /**
     * Проверяем соединение с Редисом
     * @throws Exception
     */
    private function testRedisConnection(): void
    {
        try {
            $redis = new Client([
                'scheme' => 'tcp',
                'host' => 'cache',
                'port' => getenv('REDIS_PORT'),
                'password' => ''
            ]);

            $this->redis = $redis;
        } catch (Throwable $e) {
            throw new Exception("Failed to connect to Redis with message " . $e->getMessage());
        }
    }

    /**
     * Получаем события в которых выполнены все переданные условия
     * @param array $params
     * @return array
     */
    public function getEventsByParams(array $params): array
    {
        $eventIds = $this->getEventsForParams($params);
        $eventForParams = [];
        $redisKey = self::EVENT_KEY;
        foreach ($eventIds as $eventId) {
            $eventInfo = $this->redis->hgetall("$redisKey:$eventId");
            $event = new Event($eventInfo['priority'], get_object_vars(json_decode($eventInfo['conditions'])), $eventInfo['data']);
            $eventForParams[] = $event;
        }
        usort($eventForParams, fn($a, $b) => intval($a->priority < $b->priority));
        return $eventForParams;
    }

    /**
     * Получаем id для нового события путем увелечения счетчика событий на 1
     * @param $redisKey
     * @return int
     */
    private function getId($redisKey): int
    {
        return $this->redis->incr("$redisKey:id");
    }

    /**
     * Добавляем информацию о событиях в редис
     * в формате {ключ для событий}:{id события} параметр значение
     * @param Event $event
     * @param string $redisKey
     * @param int $eventId
     * @return void
     */
    private function storeEventInfo(Event $event, string $redisKey, int $eventId): void
    {
        $properties = $event->getProperties();
        foreach ($properties as $key => $value) {
            $this->redis->hset("$redisKey:$eventId", $key, $value);
        }
    }

    /**
     * Добавляем информацию о параметрах событий в формате
     * {ключ событий::params:название параметра} поле {id события} значение {значение параметра}
     * @param array $conditions
     * @param string $redisKey
     * @param int $eventId
     * @return void
     */
    private function addEventParams(array $conditions, string $redisKey, int $eventId): void
    {
        foreach ($conditions as $param => $value) {
            $this->redis->hset("$redisKey:params:$param", $eventId, $value);
        }
    }

    /**
     * Удаление информации о событии в случае ошибки
     * @param string $redisKey
     * @param int $eventId
     * @return void
     */
    private function revertAddEvent(string $redisKey, int $eventId): void
    {
        $this->redis->decr("$redisKey:id");
        $this->redis->del("$redisKey:$eventId");
    }
}