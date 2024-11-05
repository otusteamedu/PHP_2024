<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\Entity;

use Irayu\Hw15\Domain;

class Report
{
    private string $hash;

    public function __construct(
        /**
         * @var NewsItem[]
         */
        private array $newsItems,
    ) {
        $this->generateHash();
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return NewsItem[]
     */
    public function getNewsItems(): array
    {
        return $this->newsItems;
    }

    protected function generateHash(): void
    {
        $hashData = [];
        foreach ($this->newsItems as $newsItem) {
            $hashData[] = $newsItem->getId();
        }
        $this->hash = md5(implode(',', $hashData));
    }
}
