<?php

declare(strict_types=1);

namespace AShutov\Hw14;

interface SearchInterface
{
    public function fields(): array;
    public function search(): string;
}