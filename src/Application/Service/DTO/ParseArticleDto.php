<?php

declare(strict_types=1);

namespace App\Application\Service\DTO;

use App\Domain\ValueObject\Url;

readonly class ParseArticleDto
{
    public function __construct(
        public Url $url,
    ) {
    }
}
