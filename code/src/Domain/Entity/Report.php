<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\Entity;

use Irayu\Hw15\Domain;

class Report
{
    private int $id;
    private string $hash;

    public function __construct(
        private array $newsItemIds,
    )
    {
        $this->generateHash();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return NewsItem[]
     */
    public function getNewsItemIds(): array
    {
        return $this->newsItemIds;
    }

    protected function generateHash(): void
    {
        $hash = '';
        foreach ($this->newsItemIds as $newsItemId) {
            $hash .= $newsItemId;
        }
        $this->hash = md5($hash);
    }
}