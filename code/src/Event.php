<?php

namespace Kyberlox\Event;

class Event
{
    public $jsn;
    public $data;
    public $name;
    public $priority;
    public $params;

    public function __construct($jsn) {
        $this->jsn = $jsn;
        $this->data = json_decode($this->jsn, true);
        $this->name = $this->data['Name'];
        $this->priority = $this->data['Priority'];
        $this->params = $this->data['Params'];
    }

    public function getJSON() {
        return $this->jsn;
    }

    public function getArray() {
        return $this->data;
    }

    public function ParamsJSON() {
        return json_encode($this->params);
    }

    public function ParamsArray() {
        return json_decode($this->params, true);
    }

    public function getKeys() {
        return array_keys($this->data);
    }

    public function getParamsKeys() {
        $result = $this->ParamsArray();
        return array_keys((array) $result);
    }

    public function getAllKeys() {
        return array_merge(["Priority", "Name"], $this->getParamsKeys());
    }

    public function ParamValue($key) {
        if (in_array($key, $this->getParamsKeys())) {
            $prms = $this->ParamsArray();
            return $prms[$key];
        } else {
            return false;
        }
    }
}
