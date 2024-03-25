<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Service;

interface ConditionServiceInterface
{
    public function match(string $condition, array $params): bool;
}
