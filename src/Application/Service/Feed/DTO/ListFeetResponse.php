<?php

namespace App\Application\Service\Feed\DTO;

use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

readonly class ListFeetResponse
{
    public function __construct(
        public Id $id,
        public DateTimeImmutable $date,
        public Url $url,
        public Title $title,
    ) {
    }
}
