<?php

declare(strict_types=1);

namespace Irayu\Hw15\Application\Gateway;

class UrlLoaderResponse
{
    public function __construct(
        public readonly string $content,
        public readonly string $title,
        public readonly \DateTime $dateTime,
    ) {
    }
}
