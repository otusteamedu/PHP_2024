<?php

namespace App\Infrastructure\Gateway\HttpClient;

use App\Application\Gateway\HttpClient\HttpClientGatewayInterface;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientGatewayInterface
{
    public function __invoke(HttpClientGatewayRequest $request): HttpClientGatewayResponse
    {
        return new HttpClientGatewayResponse($this->getTitle($request));
    }

    private function getTitle(HttpClientGatewayRequest $request): string
    {
        $httpClient = new Client();
        $response   = $httpClient->get($request->url->getValue());
        $htmlString = (string)$response->getBody();
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);

        $xpath = new DOMXPath($doc);
        $titles = $xpath->evaluate('//title');

        $extractedTitle = '';
        foreach ($titles as $title) {
            $extractedTitle .= $title->textContent;
        }

        return $extractedTitle;
    }
}

