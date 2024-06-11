<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Decorator;

class ShareLinkInterface implements NewsInterface
{
    public function __construct(private NewsInterface $newsDecorator)
    {
    }

    public function newsToArray()
    {
        $news = $this->newsDecorator->newsToArray();
        $newsId = $news['id'];
        $response = array("ShareLink" => "https://news/" . $newsId);
        return array_merge($response, $this->newsDecorator->newsToArray());
    }
}
