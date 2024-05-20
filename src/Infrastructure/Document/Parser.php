<?php

declare(strict_types=1);

namespace App\Infrastructure\Document;

use App\Application\Helper\DocumentParserInterface;
use App\Application\Helper\Request\DocumentParserRequest;
use App\Application\Helper\Response\DocumentParserResponse;
use DOMDocument;
use Exception;

class Parser implements DocumentParserInterface
{
    /**
     * @throws Exception
     */
    public function parse(DocumentParserRequest $dto): DocumentParserResponse
    {
        $dom = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);

        if (!$dom->loadHTMLFile($dto->url)) {
            throw new Exception("Не удалось загрузить html страницу");
        }

        libxml_use_internal_errors($internalErrors);

        $list = $dom->getElementsByTagName("title");

        if ($list->length <= 0) {
            throw new Exception("Не удалось получить заголовок страницы");
        }

        return new DocumentParserResponse($list->item(0)->textContent);
    }
}
