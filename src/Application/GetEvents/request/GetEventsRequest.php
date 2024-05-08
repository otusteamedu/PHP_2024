<?php

namespace AKornienko\Php2024\Application\GetEvents\request;

use AKornienko\Php2024\Domain\Conditions;
use Exception;

class GetEventsRequest
{
    public readonly Conditions $conditions;
    private mixed $request;

    /**
     * @throws Exception
     */
    public function __construct(string $request)
    {
        $this->request = json_decode($request, true);
        if (!$this->request) {
            throw new \InvalidArgumentException('invalid user request');
        }
        $this->conditions = new Conditions($this->request);
    }
}
