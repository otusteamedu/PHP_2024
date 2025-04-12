<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\UseCase\CreateNewsReport;

use Asyrovatkin\Hw14\Domain\Entity\News;

class ReportBuilder
{

    /**
     * @var News[]
     */
    private readonly array $newsList;

    public function __construct(array $newsList)
    {
        $this->newsList = $newsList;
    }

    public function build(): string
    {
        $result = $this->getHeader();
        $result .= $this->buildNewsList();
        $result .= $this->getFooter();
        return $result;
    }

    private function buildNewsList(): string
    {
        $list = '<ul>';
        foreach ($this->newsList as $news) {
            $list .= '<li><a href="' . $news->getUrl()->getValue() . '">' . $news->getTitle() . '</a></li>';
        }
        $list .= '</ul>';
        return $list;
    }

    private function getHeader(): string
    {
        return '
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>News List</title>
            </head>
            <body>
        ';
    }

    private function getFooter(): string
    {
        return '
            </body>
            </html>
        ';
    }
}