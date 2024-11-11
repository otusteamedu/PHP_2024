<?php

namespace Kyberlox\Rds;

require_once __DIR__ . '/Event.php';

use Kyberlox\Event\Event as Event;

class Rds
{
    public $redis;
    public $host;
    public $port;
    public $password;
    public $event;

    public function __construct($host, $port, $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;

        $this->redis = new \Redis();
        $this->redis->connect($this->host, $this->port);
        $this->redis->auth($this->password);
    }

    public function addEvent($jsn)
    {
        $this->event = new Event($jsn);
        //проверка глобального ключа
        if ($this->redis->Exists("user:0")) {
            //инкрементирую
            $keys_num = [];

            //без повторов
            $exist_keys = $this->redis->keys('*');
            $exist_names = [];
            $exist_priorities = [];
            foreach ($exist_keys as $exist_key) {
                $id = (int)substr($exist_key, 5);

                array_push($keys_num, $id);
                array_push($exist_names, $this->redis->hGet($exist_key, "Name"));
                array_push($exist_priorities, $this->redis->hGet($exist_key, "Priority"));
            };
            if ((in_array($this->event->name, $exist_names)) && (in_array($this->event->priority, $exist_priorities))) {
                return false;
            }

            $key_curr_num = max(array_unique($keys_num)) + 1;
            $key = "user:$key_curr_num";
        } else {
           $key = "user:0";
        };

        //в него закидываем ключи и их знвчения
        $this->redis->hSet($key, "Name", $this->event->name);
        $this->redis->hSet($key, "Priority", $this->event->priority);
        $this->redis->hSet($key, "Params", $this->event->paramsJSON());

        return true;
    }

    public function addEvents($jsn)
    {
        $events = json_decode($jsn, true);
        foreach ($events as $event) {
            $json = json_encode($event);
            $this->addEvent($json);
        }
    }

    public function clear()
    {
        $this->redis->flushDB();
    }

    public function filter($array)
    {
        for ($j = 0; $j < count($array); $j++) {
            for ($i = 0; $i < count($array) - 1; $i++) {
                if ($array[$i]['Priority'] > $array[$i + 1]['Priority']) {
                    $ev = $array[$i + 1];
                    $array[$i + 1] = $array[$i];
                    $array[$i] = $ev;
                };
            };
        };

        return json_encode($array);
    }

    public function search($jsn)
    {
        $data = json_decode($jsn, true);

        $result = [];
        //проходим по записям в БД
        foreach ($this->redis->keys('*') as $key) {
            $this->event = new Event(json_encode($this->redis->hGetAll($key)));
            //ключи запроса
            foreach (array_keys($data) as $search_key) {
                //совпадение по ключу
                if ($search_key == "Name") {
                    $search_value = $data["Name"];
                    $check_value = $this->event->name;
                } elseif ($this->event->paramValue($search_key)) {
                    $search_value = $data[$search_key];
                    $check_value = $this->event->paramValue($search_key);
                } else {
                    $search_value = "+";
                    $check_value = "_";
                };
                //совпадение по значению
                //если значение массив
                if (gettype($check_value) == 'array') {
                    foreach ($check_value as $value) {
                        if ( ( ( string ) $value) == ( ( string ) $search_value ) ) {
                            array_push($result, $key);
                        } elseif (str_contains((string) $value, (string) $search_value)) {
                            array_push($result, $key);
                        };
                    }
                } else {
                    if ( ( ( string ) $check_value ) == ( ( string ) $search_value ) ) {
                        array_push($result, $key);
                    } elseif (str_contains((string) $check_value, (string) $search_value)) {
                        array_push($result, $key);
                    };
                };
            };
        };
        //из подходящих событий оставить те, которые встречаются столько же, сколько условий в запросе
        $result = array_count_values($result);
        $answer = [];
        foreach (array_keys($result) as $event_key) {
            //только если выполнены все критерии
            if ($result[$event_key] == count(array_keys($data))) {
                array_push($answer, $this->redis->hGetAll($event_key));
            };
        };
        //фильтрация по приоритету
        $answer = $this->filter($answer);

        return $answer;
    }
}
