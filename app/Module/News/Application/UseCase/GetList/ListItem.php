<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetList;

use DateTimeInterface;

final readonly class ListItem
{
    public function __construct(
        public string $uuid,
        public string $url,
        public string $title,
        public DateTimeInterface $date,
    ) {
    }
}
