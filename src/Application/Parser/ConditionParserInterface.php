<?php

declare(strict_types=1);

namespace App\Application\Parser;

use App\Domain\Dto\SearchCondition;

interface ConditionParserInterface
{
    public function parse(string $condition): SearchCondition;
}