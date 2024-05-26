<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\GenerateLink;

use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkServiceInterface;
use Slim\Interfaces\RouteParserInterface;

class GenerateLinkService implements GenerateLinkServiceInterface
{
    public function __construct(
        private string $host,
        private RouteParserInterface $routeParser
    ) {
    }

    public function generateNewsReportFileLink(string $filename): string
    {
        $relativeUrl = $this->routeParser->urlFor('getNewsReport', ['filename' => $filename]);
        return $this->host . $relativeUrl;
    }
}
