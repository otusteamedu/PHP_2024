<?php

namespace App\Infrastructure\Bus;

use App\Application\Bus\Dto\NewsItemUrlBusRequestDto;
use App\Application\Bus\Dto\NewsItemUrlBusResponseDto;
use App\Application\Bus\NewsItemUrlBusInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommonNewsItemUrlBus implements NewsItemUrlBusInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    public function getNewsItemByUrl(NewsItemUrlBusRequestDto $requestDto): NewsItemUrlBusResponseDto
    {
        $url = $requestDto->url;
        $response = $this->client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Не удалось получить новость');
        }

        $content = $response->getContent();
        $crawler = new Crawler($content);
        $title = $crawler->filter('title')->text();

        return new NewsItemUrlBusResponseDto(
            $title,
            $url,
            new \DateTime()
        );
    }
}
