<?php

declare(strict_types=1);

namespace AShutov\Hw15\Requests;

use AShutov\Hw15\Conditions;
use Exception;

class AddEventRequest
{
    public readonly int $priority;
    public readonly string $event;
    public readonly Conditions $conditions;
    private ?array $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->request = json_decode($this->getUserRequestParams(), true);

        if (!$this->isValid()) {
            throw new Exception('Неверный формат данных');
        }
        $this->conditions = new Conditions($this->request['conditions']);
        $this->priority = $this->request['priority'];
        $this->event = $this->request['event'];
    }

    private function isValid(): bool
    {
        if (!$this->request) {
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
