<?php

namespace Kyberlox\Table;

require_once __DIR__ . '/Event.php';
require 'View/vendor/autoload.php';

use Kyberlox\Event\Event as Event;
use LucidFrame\Console\ConsoleTable as ConsoleTable;

class Table
{
    public $data;
    public $event;
    public $table;

    public function __construct($data)
    {
        $this->data = json_decode($data, true);
    }

    public function view()
    {
        $keys = [];
        foreach ($this->data as $ev) {
            $this->event = new Event(json_encode($ev));
            foreach ($this->event->getAllKeys() as $key) {
                if (!in_array($key, $keys)) {
                    array_push($keys, $key);
                };
            };
        };

        $this->table = new ConsoleTable();


        $this->table->setHeaders($keys);

        foreach ($this->data as $ev) {
            $this->event = new Event(json_encode($ev));
            $values = [];
            foreach ($keys as $key) {
                //если такой ключ есть в событии
                if (in_array($key, $this->event->getAllKeys())) {
                    //если это параметр
                    if (in_array($key, $this->event->getParamsKeys())) {
                        //если это массив
                        if (gettype($this->event->ParamValue($key)) == "array") {
                            array_push($values, (implode(", ", $this->event->ParamValue($key))));
                        } else {
                            array_push($values, $this->event->ParamValue($key));
                        }
                    } else {
                        $value = $this->event->getArray();
                        array_push($values, $value[$key]);
                    }
                } else {
                    array_push($values, "---");
                }
            }
            $this->table->addRow($values);
        }

        return $this->table;
    }
}