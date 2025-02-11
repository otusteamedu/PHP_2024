<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\DomCrawler;
use App\Application\Gateway\DomCrawlerRequest;
use App\Application\Gateway\DomCrawlerResponse;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class SymfonyDomCrawler implements DomCrawler
{

    public function __construct(
        private Crawler             $crawler,
        private HttpClientInterface $httpClient
    )
    {
    }

    public function getTitle(DomCrawlerRequest $request): DomCrawlerResponse
    {
        $response = $this->httpClient->request('GET', $request->getUrl());

        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException(
                sprintf(
                    'Ошибка при получении title - статус %d',
                    $response->getStatusCode()
                )
            );
        }

        $this->crawler
            ->add($response->getContent());

        $title = $this->crawler
            ->filter('title')
            ->text();

        return new DomCrawlerResponse($title);
    }
}