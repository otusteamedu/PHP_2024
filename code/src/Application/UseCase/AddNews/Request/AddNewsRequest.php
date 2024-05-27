<?php
declare(strict_types=1);

namespace App\Application\UseCase\AddNews\Request;

readonly class AddNewsRequest
{
    public function __construct(
        public string $url,
        public string $title,
        public string $date
    )
    {}

}