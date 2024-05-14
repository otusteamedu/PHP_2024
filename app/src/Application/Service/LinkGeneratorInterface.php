<?php

declare(strict_types=1);

namespace App\Application\Service;

interface LinkGeneratorInterface
{
    public function generate(string $filename): string;
}
