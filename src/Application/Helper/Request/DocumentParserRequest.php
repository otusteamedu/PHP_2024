<?php

declare(strict_types=1);

namespace App\Application\Helper\Request;

class DocumentParserRequest
{
    public function __construct(
        public readonly string $url
    ) {}
}
