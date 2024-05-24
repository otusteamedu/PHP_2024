<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser;

use App\Application\Parser\HtmlParserInterface;
use App\Application\UseCase\Request\HtmParseRequest;
use App\Application\UseCase\Response\HtmlParseResponse;
use App\Domain\Exception\DomainException;

class HtmlParser implements HtmlParserInterface
{
    public function parseTitle(HtmParseRequest $request): HtmlParseResponse
    {
        if (!preg_match('~<title>(.*?)</title>~siu', $request->html, $matches) ) {
            throw new DomainException('Failed to parse title');
        }
        $title = $matches[1] ?? '';
        return new HtmlParseResponse($title);
    }
}