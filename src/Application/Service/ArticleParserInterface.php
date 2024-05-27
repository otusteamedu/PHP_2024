<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Service\DTO\ParsedArticleDto;
use App\Domain\ValueObject\Url;

interface ArticleParserInterface
{
    public function parseArticle(Url $url): ParsedArticleDto;
}
