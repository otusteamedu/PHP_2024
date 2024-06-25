<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Service\DTO\ParseArticleDto;
use App\Application\Service\DTO\ParsedArticleDto;

interface ArticleParserInterface
{
    public function parseArticle(ParseArticleDto $parseArticleDto): ParsedArticleDto;
}
