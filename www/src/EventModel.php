<?php

namespace Builov\RedisApp;

use Exception;

class EventModel
{
    private DbConnector $dbConnection;

    function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @param array $eventConditionName
     * @param array $eventConditionValue
     * @param int $eventPriority
     * @param string $eventDescription
     * @return string
     * @throws Exception
     */
    public function create(array $eventConditionName, array $eventConditionValue, int $eventPriority, string $eventDescription): string
    {
        if (
            empty($eventConditionName)
            || empty($eventConditionValue)
            || count($eventConditionName) !== count($eventConditionValue)
            || empty($eventPriority)
            || empty($eventDescription)
        ) {
            throw new Exception('Ошибка ввода данных. Событие не создано.');
        }

        $conditions = [];
        foreach ($eventConditionName as $key => $conditionName) {
            if (!empty($conditionName) && !empty($eventConditionValue[$key])) {
                $conditions[$conditionName] = $eventConditionValue[$key];
            }
        }

        $eventId = md5(microtime());

        $this->dbConnection->addToHashMulti($eventId, ['priority' => $eventPriority, 'conditions' => json_encode($conditions), 'event' => $eventDescription]);

        foreach ($conditions as $conditionName => $conditionValue) {
            $this->dbConnection->addToSet($conditionName . ':' . $conditionValue, $eventId);
            $this->dbConnection->addToSet('conditions', $conditionName . ':' . $conditionValue);
        }

        return $eventDescription;
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function get(array $conditions): array
    {
        $eventIds = []; //массив событий, соответствующих какому либо из условий
        foreach ($conditions as $condition) {
            $eventsList = $this->dbConnection->getSetMembers($condition);
            foreach ($eventsList as $eventId) {
                $eventIds[$eventId] = $eventId;
            }
        }

        $match = [];
        foreach ($eventIds as $eventId) { //для каждого события проверяется соответствие всем условиям, а не только одному из
            $event = $this->dbConnection->getHashMembers($eventId);

            $conditionsArray = [];
            foreach (json_decode($event['conditions']) as $condition => $conditionValue) {
                $conditionsArray[] = $condition . ':' . $conditionValue;
            }

            if (empty(array_diff($conditionsArray, $conditions))) { //проверка на соответствие всем условиям
                if (empty($priority) || $event['priority'] > $priority) { //и выбор события с наивысшим приоритетом
                    $match = $event;
                }
            }

            $priority = $event['priority']; //для сравнения со след. событием
        }

        return $match;
    }

    /**
     * @return bool
     */
    public function deleteAll(): bool
    {
        return $this->dbConnection->flushDb();
    }

    /**
     * @return array
     */
    public function getExistingConditions(): array
    {
        return $this->dbConnection->getSetMembers('conditions');
    }
}
