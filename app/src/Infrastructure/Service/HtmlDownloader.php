<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Service;

class HtmlDownloader
{
    public function download(string $url): string
    {
        $content = file_get_contents($url);

        if ($content === false) {
            throw new \RuntimeException('Failed to fetch content from URL: ' . $url);
        }

        return $content;
    }
}
