<?php

declare(strict_types=1);

namespace App\Application\UseCase\Mapper;

use App\Application\UseCase\DTO\NewsDTO;
use App\Domain\Entity\News;

class NewsMapper
{
    public static function toDTO(News $news): NewsDTO
    {
        return new NewsDTO(
            $news->getId(),
            $news->getUrl()->getValue(),
            $news->getTitle()->getValue(),
            $news->getDate()->format('Y-m-d H:i:s')
        );
    }
}
