<?php

declare(strict_types=1);

namespace App\Application\Service;

interface UuidGeneratorInterface
{
    public function generateUuid(): string;
}
