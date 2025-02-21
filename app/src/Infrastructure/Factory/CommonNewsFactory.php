<?php

namespace AnatolyShilyaev\Hw15\Infrastructure\Factory;

use AnatolyShilyaev\Hw15\Domain\Entity\News;
use AnatolyShilyaev\Hw15\Domain\Factory\NewsFactoryInterface;
use AnatolyShilyaev\Hw15\Domain\ValueObject\Date;
use AnatolyShilyaev\Hw15\Domain\ValueObject\Title;
use AnatolyShilyaev\Hw15\Domain\ValueObject\Url;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(string $url): News
    {
        return new News(
            new Title($this->getTitle($url)),
            new Date(date('Y-m-d')),
            new Url($url)
        );
    }

    private function getTitle($url): string
    {
        // Указываем User-Agent как браузер
        $options = [
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $fp = file_get_contents($url, false, $context);

        if (!$fp) {
            return null;
        }

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) {
            return null;
        }

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }
}
