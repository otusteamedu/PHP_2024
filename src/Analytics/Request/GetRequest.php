<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Request;

use AlexanderGladkov\Analytics\Application\Arg\GetArg;

class GetRequest
{
    private array $conditions;

    private function __construct()
    {
    }

    public static function createByArgs(array $args): self
    {
        $conditions = $args[GetArg::Condition->value];
        $conditions = (new RequestValidationHelper())->validateConditionArg($conditions);
        $request = new self();
        $request->conditions = $conditions;
        return $request;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }
}
