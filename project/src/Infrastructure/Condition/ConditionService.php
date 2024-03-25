<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition;

use SFadeev\Hw12\Domain\Service\ConditionServiceInterface;

class ConditionService implements ConditionServiceInterface
{
    public function __construct(
        private Parser $parser
    ) {
    }

    public function match(string $condition, array $params): bool
    {
        $expression = $this->parser->parse($condition);

        return $expression->resolve($params);
    }
}
