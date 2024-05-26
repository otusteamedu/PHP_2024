<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\LinkGeneratorDto;

interface LinkGeneratorInterface
{
    public function generate(string $filename): LinkGeneratorDto;
}
