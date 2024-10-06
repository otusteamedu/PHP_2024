<?php
namespace AgapitovAlexandr\OtusHomework;

use Exception;

class App
{
    private static \Predis\Client $Client;

    public function __construct()
    {
        $CONFIG = include_once 'config.php';

        self::$Client = new \Predis\Client(['host' => $CONFIG['redis_host'], 'port' => $CONFIG['redis_port'],]);
    }

    public function run()
    {
        $args = $_SERVER['argv'];

        switch ($args[1]) {
            case 'init':
                $this->init();
                break;
            case 'search': // '{"params": {"params1":1,"params2":2}}'
                $this->search($args[2]);
                break;
            case 'add': // '{"priority": 35000, "conditions": {"params1": 1}, "event": "Событие 3"}'
                $this->add($args[2]);
                break;
            case 'clear': // '{"priority": 35000, "conditions": {"params1": 1}, "event": "Событие 3"}'
                $this->clear();
                break;
            default:
                throw new Exception('Command not found');
                break;
        }
    }

    private function init()
    {
        $init = json_decode('[{"priority": 1000, "conditions": {"params1": 1}, "event": "Событие 1"}, {"priority": 2000, "conditions": {"params1": 2, "params2": 2}, "event": "Событие 2"}, {"priority": 3000, "conditions": {"params1": 1, "params2": 2}, "event": "Событие 3"}]', true);

        $this->clear();

        $id = 1;
        foreach ($init AS $event) {
            $this->setEvent($id, $event['priority'], $event['conditions'], $event['event']);
            $id++;
        }
    }

    private function add(string $event_json = null)
    {
        $event = !empty($event_json) ? json_decode($event_json, true) : null;
        if (empty($event)) {
            throw new Exception('Error in event string');
        }

        $total_items = $this->getTotal();
        $this->setEvent(++$total_items, $event['priority'], $event['conditions'], $event['event']);
    }

    private function setEvent(int $id, int $priority = null, array $conditions = null, string $event = null)
    {
        if (empty($priority)) {
            throw new Exception('Priority required');
        }
        if (empty($conditions)) {
            throw new Exception('Conditions required');
        }
        if (empty($event)) {
            throw new Exception('Event required');
        }

        $event = new Event($priority, $conditions, $event);

        $priority = self::$Client->executeRaw(["GET", "priority:{$event->priority}"], $error);
        if (false !== $error) {
            throw new Exception('Error get priority: ' . $error);
        }

        if (!empty($priority) && (int)$priority === 1) {
            throw new Exception("Priority {$event->priority} exists");
        }

        self::$Client->executeRaw(["ZADD", "priority", $event->priority, $id], $error);
        if (false !== $error) {
            throw new Exception('Error priority event: ' . $error);
        }

        self::$Client->executeRaw(["SET", "priority:{$event->priority}", 1], $error);
        if (false !== $error) {
            throw new Exception('Error set priority in list: ' . $error);
        }

        foreach ($event->conditions AS $key => $value) {
            self::$Client->executeRaw(["RPUSH", "$key:$value", $id], $error);
            if (false !== $error) {
                throw new Exception('Error condition event: ' . $error);
            }
        }

        self::$Client->executeRaw(["SET", "params:$id", json_encode(array_keys($event->conditions))], $error);
        if (false !== $error) {
            throw new Exception('Error event event: ' . $error);
        }

        self::$Client->executeRaw(["SET", "events:$id", $event->event], $error);
        if (false !== $error) {
            throw new Exception('Error event event: ' . $error);
        }
    }

    private function search(string $params_json = null)
    {
        $params = !empty($params_json) ? json_decode($params_json, true) : null;
        if (empty($params)) {
            throw new Exception('Error in search param');
        }

        $helper = $finds = [];

        $total_items = $this->getTotal();

        $count_params = count($params['params']);

        foreach ($params['params'] AS $key => $value) {
            $finds[$key] = self::$Client->executeRaw(["LRANGE", "$key:$value", 0, $total_items], $error);
            if (false !== $error) {
                throw new Exception('Error find condition: ' . $error);
            }
            foreach ($finds[$key] AS $k => $v) {
                $helper[$v][$key] = $k;
            }
        }

        $full_find = array_filter($helper, fn($t) => count($t) === $count_params) ?? [];

        foreach ($helper AS $key => $value) {
            if (in_array($key, array_keys($full_find))) continue;

            $search = self::$Client->executeRaw(["GET", "params:$key"], $error);
            if (false !== $error || empty($search)) {
                throw new Exception('Error get another params: ' . $error);
            }
            $search = json_decode($search, true);
            if (empty(array_diff($search, array_keys($value)))) {
                $full_find[$key] = $value;
            }
        }

        $max = null;
        $priorities = [];
        foreach (array_keys($full_find) AS $value) {
            $priority = self::$Client->executeRaw(["ZRANK", "priority", $value], $error);
            if (false !== $error) {
                throw new Exception('Error get priority: ' . $error);
            }
            $priorities[$priority] = $value;
            $max = max($priority, $max);
        }

        if ($priorities[$max]) {
            echo "Find: ".$priorities[$max];
        } else {
            echo "Event not found";
        }
    }

    private function getTotal()
    {
        $total = self::$Client->executeRaw(["ZCARD", "priority"], $error);
        if (false !== $error) {
            throw new Exception('Error get total items: ' . $error);
        }
        return $total;
    }

    private function clear()
    {
        self::$Client->executeRaw(["FLUSHDB"], $error);
        if (false !== $error) {
            throw new Exception('Error clear events');
        }
    }
}