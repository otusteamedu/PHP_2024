<?php

declare(strict_types=1);

namespace Module\News\Domain\Entity;

final class NewsCollection
{
    /** @var array<string, News> */
    private array $items = [];

    public function __construct(News ...$news)
    {
        foreach ($news as $item) {
            $this->add($item);
        }
    }

    public function add(News $item): void
    {
        if (!$this->has($item)) {
            $this->items[$item->getId()] = $item;
        }
    }

    /**
     * @return News[]
     */
    public function all(): array
    {
        return array_values($this->items);
    }

    public function has(News $item): bool
    {
        return isset($this->items[$item->getId()]);
    }
}
