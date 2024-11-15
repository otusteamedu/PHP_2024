<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\WebsiteParser;

use App\MediaMonitoring\Application\Exception\CouldNotParseWebsiteException;
use App\MediaMonitoring\Application\WebsiteParser\WebsiteParserInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class WebsiteParser implements WebsiteParserInterface
{
    private ?Crawler $crawler = null;

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {}

    public function parse(string $url): self
    {
        try {
            $content = $this->httpClient
                ->request(Request::METHOD_GET, $url)
                ->getContent()
            ;
        } catch (Throwable $e) {
            $message = sprintf('Could not parse website by URL [%s]', $url);

            throw new CouldNotParseWebsiteException($message, $e->getCode(), $e);
        }

        $this->crawler = (new Crawler($content));

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->crawler?->filter('title')->text();
    }
}
