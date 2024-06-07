<?php

declare(strict_types=1);

namespace App\Application\Helper\Mapper;

use App\Application\Helper\DTO\NewsReportDTO;
use App\Domain\Entity\News;

class NewsMapper
{
    public static function toNewsReportDTO(News $news): NewsReportDTO
    {
        return new NewsReportDTO(
            $news->getUrl()->getValue(),
            $news->getTitle()->getValue(),
        );
    }
}
