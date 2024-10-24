<?php

namespace Src;

require_once 'vendor/autoload.php';

use Predis\Client;

class EventManager {
    private $redis;

    public function __construct() {
        $this->redis = new Client();
    }

    // Добавление события
    public function addEvent($priority, $conditions, $event) {
        $eventData = [
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event
        ];
        $this->redis->rpush('events', json_encode($eventData));
    }

   
    public function clearEvents() {
        $this->redis->del('events');
    }

    public function getBestEvent($params) {
        $events = $this->redis->lrange('events', 0, -1);
        $bestEvent = null;
        $bestPriority = -1;

        foreach ($events as $eventJson) {
            $event = json_decode($eventJson, true);
            if ($this->matchConditions($event['conditions'], $params)) {
                if ($event['priority'] > $bestPriority) {
                    $bestPriority = $event['priority'];
                    $bestEvent = $event;
                }
            }
        }

        return $bestEvent;
    }

    
    private function matchConditions($conditions, $params) {
        foreach ($conditions as $key => $value) {
            if (!isset($params[$key]) || $params[$key] != $value) {
                return false;
            }
        }
        return true;
    }
}
