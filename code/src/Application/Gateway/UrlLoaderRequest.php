<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\Gateway;

class UrlLoaderRequest
{
    public function __construct(
        public readonly string $url,
    ) {
    }
}
