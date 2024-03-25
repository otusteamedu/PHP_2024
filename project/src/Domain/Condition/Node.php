<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Condition;

abstract class Node
{
    abstract public function resolve(array $params): mixed;
}
