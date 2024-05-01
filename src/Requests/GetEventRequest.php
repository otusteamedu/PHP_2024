<?php

declare(strict_types=1);

namespace AShutov\Hw15\Requests;

use AShutov\Hw15\Conditions;
use Exception;

class GetEventRequest
{
    public readonly Conditions $conditions;
    private mixed $request;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->request = json_decode($this->getUserRequestParams(), true);

        if (!$this->isValid()) {
            throw new Exception('Неверный запрос');
        }
        $this->conditions = new Conditions($this->request);
    }

    private function isValid(): bool
    {
        if (!$this->request) {
            return false;
        }

        return true;
    }

    private function getUserRequestParams(): string
    {
        return $_SERVER['argv'][2] ?? '';
    }
}
