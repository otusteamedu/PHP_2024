<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Repositories\EventSystem;

use Exception;
use RailMukhametshin\Hw\Dto\EventSystem\EventObject;
use RailMukhametshin\Hw\Dto\FieldValue;
use Redis;
use RedisException;

class RedisEventRepository implements EventRepositoryInterface
{
    private const KEY = 'event-system:events';
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @throws RedisException
     */
    public function add(EventObject $eventObject): void
    {
        $this->redis->zAdd(self::KEY, $eventObject->priority, serialize($eventObject));
    }

    /**
     * @throws RedisException
     */
    public function removeAll(): void
    {
        $this->redis->del(self::KEY);
    }

    public function getByParams(array $params): ?EventObject
    {
        $items = $this->getAll();
        $items = array_reverse($items);
        /** @var EventObject $item */
        foreach ($items as $item) {
            if ($this->checkEventByParams($item, $params)) {
                return $item;
            }
        }

        return null;
    }

    private function checkEventByParams(EventObject $eventObject, array $params): bool
    {
        $conditions = $eventObject->conditions;
        $countConditions = count($conditions);
        $countCheck = 0;

        /** @var FieldValue $param */
        foreach ($params as $param) {
            if (isset($conditions[$param->field])) {
                $val = $conditions[$param->field];
                if ($val === $param->value) {
                    $countCheck++;
                }
            }
        }

        return $countConditions === $countCheck;
    }

    /**
     * @throws RedisException
     */
    public function getAll(): array
    {
        $result = [];
        $items = $this->redis->zRange(self::KEY, 0, -1);
        foreach ($items as $item) {
            try {
                $object = unserialize($item);
            } catch (Exception $exception) {
                continue;
            }

            if ($object instanceof EventObject) {
                $result[] = $object;
            }
        }

        return $result;
    }
}
