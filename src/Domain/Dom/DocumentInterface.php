<?php

declare(strict_types=1);

namespace App\Domain\Dom;

interface DocumentInterface
{
    public function getTitleByUrl(string $url): string;
}
