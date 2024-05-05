<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class ReportLine
{
    public readonly string $url;
    public readonly string $title;

    public function __construct(Url $url, NewsTitle $title)
    {
        $this->url = $url->getValue();
        $this->title = $title->getValue();
    }
}
