<?php

declare(strict_types=1);

namespace App\Application\Parser;

use App\Application\UseCase\Request\HtmParseRequest;
use App\Application\UseCase\Response\HtmlParseResponse;

interface HtmlParserInterface
{
    public function parseTitle(HtmParseRequest $request): HtmlParseResponse;
}