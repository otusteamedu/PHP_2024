<?php

declare(strict_types=1);

namespace App\Infrastructure\Crawler;

use App\Application\Crawler\Dto\NewsItemCrawlerRequestDto;
use App\Application\Crawler\Dto\NewsItemCrawlerResponseDto;
use App\Application\Crawler\NewsItemCrawlerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommonNewsItemCrawler implements NewsItemCrawlerInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    public function getNewsItemByUrl(NewsItemCrawlerRequestDto $requestDto): NewsItemCrawlerResponseDto
    {
        $url = $requestDto->url;
        $response = $this->client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Не удалось получить новость');
        }

        $content = $response->getContent();
        $crawler = new Crawler($content);
        $title = $crawler->filter('title')->text();

        return new NewsItemCrawlerResponseDto(
            $title,
            $url,
            new \DateTimeImmutable()
        );
    }
}
