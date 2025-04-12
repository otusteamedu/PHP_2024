<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\WebParser;

use Asyrovatkin\Hw14\Domain\ValueObject\Url;

class WebParserRequest
{
    private readonly Url $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }
    public function getUrl(): Url
    {
        return $this->url;
    }
}