<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Application\Helper\Request\DocumentParserRequest;
use App\Application\Helper\Response\DocumentParserResponse;

interface DocumentParserInterface
{
    public function parse(DocumentParserRequest $dto): DocumentParserResponse;
}
