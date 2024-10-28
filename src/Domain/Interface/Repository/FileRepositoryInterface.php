<?php

namespace App\Domain\Interface\Repository;

interface FileRepositoryInterface
{
    public function storeHtmlNewsList(string $content): string;
}
