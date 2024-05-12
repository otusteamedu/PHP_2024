<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;

class NewsItemLoader
{
    public function __construct(private string $url)
    {
    }

    public function run(): Application\UseCase\Request\AddNewsItemRequest
    {
        $htmlContent = file_get_contents($this->url);

        $dom = new \DOMDocument();
        if ($dom->loadHTML($htmlContent, LIBXML_NOWARNING | LIBXML_NOERROR)) {
            $xpath = new \DOMXPath($dom);

            $titleNode = $xpath->query('//title')->item(0);
            $title = $titleNode->nodeValue;

            /*        $mainContentNode = $xpath->query('//div[@class="main-content"]')->item(0);
                    $mainContent = $dom->saveHTML($mainContentNode);*/

            return new Application\UseCase\Request\AddNewsItemRequest(
                url: $this->url,
                title: $title,
                date: new \DateTime('now'),
            );
        } else {
            throw new \Exception('Failed to load HTML content');
        }
    }
}
