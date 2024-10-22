<?php

declare(strict_types=1);

namespace App\Application\Report\Dto;

class SubmitReportGeneratorRequestDto
{
    private array $newsItems;

    public function __construct(array $newsItem)
    {
        foreach ($newsItem as $item) {
            $this->newsItems[] = $item;
        }
    }

    public function getNewsItems(): array
    {
        return $this->newsItems;
    }
}
