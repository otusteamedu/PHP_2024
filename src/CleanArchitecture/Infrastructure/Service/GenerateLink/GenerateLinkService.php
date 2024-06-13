<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\GenerateLink;

use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkResult;
use AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink\GenerateLinkServiceInterface;
use Slim\Interfaces\RouteParserInterface;

class GenerateLinkService implements GenerateLinkServiceInterface
{
    public function __construct(
        private string $host,
        private RouteParserInterface $routeParser
    ) {
    }

    public function generateLinkToNewsReportToFile(GenerateLinkParams $params): GenerateLinkResult
    {
        $relativeUrl = $this->routeParser->urlFor('getNewsReport', ['filename' => $params->getFilename()]);
        return new GenerateLinkResult($this->host . $relativeUrl);
    }
}
