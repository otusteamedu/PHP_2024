<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Service;

use SFadeev\Hw12\Domain\Condition\ParserInterface;

class ConditionService
{
    public function __construct(
        private ParserInterface $parser
    )
    {
    }

    public function match(string $condition, array $params): bool
    {
        $expression = $this->parser->parse($condition);

        return $expression->resolve($params);
    }
}
