<?php

namespace AKornienko\Php2024\requests;

use AKornienko\Php2024\models\Conditions;
use AKornienko\Php2024\models\Event;
use Exception;

class AddEventRequest
{
    public readonly int $priority;
    public readonly Event $event;
    public readonly Conditions $conditions;
    private array $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->request = json_decode($this->getUserRequestParams(), true);
        if (!$this->isValid()) {
            throw new Exception('invalid user request');
        }

        $this->conditions = new Conditions($this->request['conditions']);
        $this->priority = $this->request['priority'];
        $this->event = new Event($this->request['event']['name'], $this->request['event']['description']);
    }

    private function isValid(): bool
    {
        if (!$this->request) {
            return false;
        }

        if (!Event::isValidPayload($this->request['event'])) {
            return false;
        }

        if (!is_int($this->request['priority'])) {
            return false;
        }
        return true;
    }

    private function getUserRequestParams(): string
    {
        return $_SERVER['argv'][2] ?? '';
    }
}
