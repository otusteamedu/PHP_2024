<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition\AST;

use InvalidArgumentException;
use SFadeev\Hw12\Domain\Condition\Node;

class Comparison extends Node
{
    public const T_EQUAL = '=';

    public function __construct(
        public Node|int|float|string|bool|null $leftExpression,
        public string                          $operator,
        public Node|int|float|string|bool|null $rightExpression,
    ) {
        $allowed = [self::T_EQUAL];

        if (!in_array($this->operator, $allowed, true)) {
            throw new InvalidArgumentException(sprintf('Expected: %s, got %s', implode(', ', $allowed), $operator));
        }
    }

    public function resolve(array $params): bool
    {
        return match ($this->operator) {
            self::T_EQUAL => $this->getValue($this->leftExpression, $params) === $this->getValue($this->rightExpression, $params)
        };
    }

    private function getValue(Node|int|float|string|bool|null $expression, array $params)
    {
        if ($expression instanceof Node) {
            return $expression->resolve($params);
        }

        return $expression;
    }
}
