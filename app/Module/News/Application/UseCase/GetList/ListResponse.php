<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\GetList;

final readonly class ListResponse
{
    public array $items;

    public function __construct(ListItem ...$items)
    {
        $this->items = $items;
    }
}
