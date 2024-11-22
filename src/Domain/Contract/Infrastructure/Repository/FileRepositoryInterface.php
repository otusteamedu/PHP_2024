<?php

namespace App\Domain\Contract\Infrastructure\Repository;

interface FileRepositoryInterface
{
    public function storeHtmlNewsList(string $content): string;
}
