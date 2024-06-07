<?php

declare(strict_types=1);

namespace App\Application\Helper\DTO;

readonly class NewsPageDTO
{
    public function __construct(public string $html)
    {
    }
}
