<?php

declare(strict_types=1);

namespace App\Infrastructure\Dom;

use App\Domain\Dom\DocumentInterface;
use DOMDocument;
use Exception;

class Document implements DocumentInterface
{
    /**
     * @throws Exception
     */
    public function getTitleByUrl(string $url): string
    {
        $dom = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);

        if (!$dom->loadHTMLFile($url)) {
            throw new Exception("Не удалось загрузить html страницу");
        }

        libxml_use_internal_errors($internalErrors);

        $list = $dom->getElementsByTagName("title");

        if ($list->length <= 0) {
            throw new Exception("Не удалось получить заголовок страницы");
        }

        return $list->item(0)->textContent;
    }
}
