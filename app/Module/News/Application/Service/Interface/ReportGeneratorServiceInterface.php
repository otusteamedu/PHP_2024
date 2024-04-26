<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Interface;

use Module\News\Application\Service\Dto\NewsDto;
use Module\News\Domain\ValueObject\Url;

interface ReportGeneratorServiceInterface
{
    public function generate(NewsDto $newsDto, NewsDto ...$newsDtoList): Url;
}
