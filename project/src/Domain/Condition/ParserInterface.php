<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Condition;

interface ParserInterface
{
    public function parse(string $input): Node;
}
