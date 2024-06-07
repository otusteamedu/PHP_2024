<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\ArticleParserInterface;
use App\Application\Gateway\Request\NewsRequest;
use App\Application\Gateway\Response\NewsResponse;
use GuzzleHttp\Client;

readonly class HttpArticleParser implements ArticleParserInterface
{
    public function __construct(private Client $client)
    {
    }

    public function parse(NewsRequest $request): NewsResponse
    {
        $response = $this->client->get($request->url);
        $content = $response->getBody()->getContents();
        return new NewsResponse($content);
    }
}
