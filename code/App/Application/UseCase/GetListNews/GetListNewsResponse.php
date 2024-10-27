<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetListNews;

class GetListNewsResponse
{
    public array $news_list;
    public function __construct(
        array $news_list
    )
    {
        $this->news_list = $news_list;
    }
}