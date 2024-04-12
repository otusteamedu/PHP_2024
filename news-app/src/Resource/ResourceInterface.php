<?php

declare(strict_types=1);

namespace App\Resource;

interface ResourceInterface
{
    public function toArray(): array;
}