<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\AskNewsList;

use Asyrovatkin\Hw14\Domain\Entity\News;

class AskNewsListResponse
{

    /**
     * @var News[]
     */
    private readonly array $newsList;

    public function __construct($newsList)
    {
        $this->newsList = $newsList;
    }

    /**
     * @return News[]
     */
    public function getNewsList(): array
    {
        return $this->newsList;
    }

    public function __toString(): string
    {
        $result = [];
        foreach ($this->newsList as $news) {
            $result[] = [
                'id' => $news->getId(),
                'title' => $news->getTitle(),
                'url' => $news->getUrl()->getValue(),
                'date' => $news->getDate()
            ];
        }
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}