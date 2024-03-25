<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition\AST;

use InvalidArgumentException;
use SFadeev\Hw12\Domain\Condition\Node;

class Logical extends Node
{
    public const T_AND = 'AND';

    /**
     * @param Node|bool $leftExpression
     * @param string $operator
     * @param Node|bool $rightExpression
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        public Node|bool $leftExpression,
        public string    $operator,
        public Node|bool $rightExpression,
    )
    {
        $allowed = [self::T_AND];

        if (!in_array($this->operator, $allowed, true)) {
            throw new InvalidArgumentException(sprintf('Expected: %s, got %s', implode(', ', $allowed), $operator));
        }
    }

    public function resolve(array $params): bool
    {
        return match ($this->operator) {
            self::T_AND => $this->getBool($this->leftExpression, $params) && $this->getBool($this->rightExpression, $params)
        };
    }

    private function getBool(Node|bool $expression, array $params)
    {
        if (is_bool($expression)) {
            return $expression;
        }

        return $expression->resolve($params);
    }
}
