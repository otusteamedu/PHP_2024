<?php
namespace AgapitovAlexandr\OtusHomework;

use Exception;

class App
{

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
            case 'clear':
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

        $Storage = new Storage();

        $Storage->clear();

        foreach ($init AS $event_array) {
            if (empty($event_array['priority'])) {
                throw new Exception('Priority required');
            }
            if (empty($event_array['conditions'])) {
                throw new Exception('Conditions required');
            }
            if (empty($event_array['event'])) {
                throw new Exception('Event required');
            }

            $event = new Event($event_array['priority'], $event_array['conditions'], $event_array['event']);
            $Storage->addEvent($event);
        }
    }

    private function add(string $event_json = null)
    {
        $event_array = !empty($event_json) ? json_decode($event_json, true) : null;
        if (empty($event_array)) {
            throw new Exception('Error in event string');
        }

        $event = new Event($event_array['priority'], $event_array['conditions'], $event_array['event']);
        $Storage = new Storage();
        $Storage->addEvent($event);
    }

    private function search(string $params_json = null)
    {
        $params = !empty($params_json) ? json_decode($params_json, true) : null;
        if (empty($params)) {
            throw new Exception('Error in search param');
        }
        $Storage = new Storage();
        $Storage->search($params['params']);
    }

    private function clear()
    {
        $Storage = new Storage();
        $Storage->clear();
    }
}