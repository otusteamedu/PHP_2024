<?php

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Infrastructure\Repository\FileRepositoryInterface;

class FileRepository implements FileRepositoryInterface
{
    public function storeHtmlNewsList(string $content): string
    {
        $fileName = $_ENV['HTML_NEWS_LIST_FILE_NAME'];
        $href = 'http://' . $_ENV['APP_URL'] . ":" . $_ENV['APP_PORT']
                . "/" . $fileName;

        $result = file_put_contents($fileName, $content);

        return $result ? $href : 'error';
    }
}
