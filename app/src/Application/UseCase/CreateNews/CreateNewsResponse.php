<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Application\UseCase\CreateNews;

class CreateNewsResponse
{
    private int $newsId;

    public function __construct(int $newsId)
    {
        $this->newsId = $newsId;
    }

    public function getNewsId(): int
    {
        return $this->newsId;
    }
}
