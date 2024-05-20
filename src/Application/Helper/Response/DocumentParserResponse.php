<?php

declare(strict_types=1);

namespace App\Application\Helper\Response;

class DocumentParserResponse
{
    public function __construct(
        public readonly string $title
    ) {}
}
