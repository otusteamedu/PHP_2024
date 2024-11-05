<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Gateway;

use Irayu\Hw15\Application\Gateway\UrlLoaderInterface;
use Irayu\Hw15\Application\Gateway\UrlLoaderRequest;
use Irayu\Hw15\Application\Gateway\UrlLoaderResponse;

class NewsLoader implements UrlLoaderInterface
{
    public function getContent(UrlLoaderRequest $request): UrlLoaderResponse
    {
        $htmlContent = file_get_contents($request->url);

        $dom = new \DOMDocument();
        if ($dom->loadHTML($htmlContent, LIBXML_NOWARNING | LIBXML_NOERROR)) {
            $xpath = new \DOMXPath($dom);

            $titleNode = $xpath->query('//title')->item(0);
            $title = $titleNode->nodeValue;

            $mainContentNode = $xpath->query('//body')->item(0);
            $mainContent = $dom->saveHTML($mainContentNode);

            return new UrlLoaderResponse(
                content: $mainContent,
                title: $title,
                dateTime: new \DateTime('now'),
            );
        } else {
            throw new \Exception('Failed to load HTML content');
        }
    }
}
