<?php

declare(strict_types=1);

namespace App\Application\DocumentParser;

use App\Application\DocumentParser\Request\DocumentParserRequest;
use App\Application\DocumentParser\Response\DocumentParserResponse;

interface DocumentParserInterface
{
    public function parse(DocumentParserRequest $dto): DocumentParserResponse;
}
