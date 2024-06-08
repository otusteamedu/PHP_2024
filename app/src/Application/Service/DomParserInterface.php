<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\DomDto;
use App\Application\Dto\DomParserDto;

interface DomParserInterface
{
    public function parseTag(DomDto $dto): DomParserDto;
}
