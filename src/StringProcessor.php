<?php

declare(strict_types=1);

namespace String\StringProcessor;

class StringProcessor
{
    public function getLength(string $s): int
    {
        return mb_strlen($s);
    }
}
