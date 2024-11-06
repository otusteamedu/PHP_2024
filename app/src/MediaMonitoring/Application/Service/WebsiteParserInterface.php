<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\Service;

use App\MediaMonitoring\Application\Exception\CouldNotParseWebsiteException;

interface WebsiteParserInterface
{
    /**
     * @throws CouldNotParseWebsiteException
     */
    public function parse(string $url): self;

    public function getTitle(): ?string;
}
