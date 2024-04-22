<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Request;

use AlexanderGladkov\Analytics\Application\Arg\AddArg;

class AddRequest
{
    private int $priority;
    private array $conditions;
    private string $value;

    private function __construct()
    {
    }

    public static function createByArgs(array $args): self
    {
        $args = (new AddRequestValidation())->validateArgs($args);
        $addRequest = new self();
        $addRequest->priority = $args[AddArg::Priority->value];
        $addRequest->value = $args[AddArg::Value->value];
        $addRequest->conditions = $args[AddArg::Condition->value];
        return $addRequest;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
