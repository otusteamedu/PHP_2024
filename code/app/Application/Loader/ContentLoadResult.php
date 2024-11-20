<?php

declare(strict_types=1);

namespace App\Application\Loader;

readonly class ContentLoadResult
{
    public function __construct(
        public string $content
    )
    {
    }
}
