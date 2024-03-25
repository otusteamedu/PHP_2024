<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition\AST;

class Parameter extends Node
{
    public function __construct(
        public string $name,
    ) {
    }

    public function resolve(array $params): int|float|string|bool|null
    {
        if (array_key_exists($this->name, $params)) {
            return $params[$this->name];
        }

        return null;
    }
}
