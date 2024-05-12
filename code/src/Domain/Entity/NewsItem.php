<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\Entity;

use Irayu\Hw15\Domain;

class NewsItem
{
    private int $id;

    public function __construct(
        private Domain\ValueObject\Url $url,
        private Domain\ValueObject\Title $title,
        private Domain\ValueObject\Date $date,
    ) {}

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getDate(): Domain\ValueObject\Date
    {
        return $this->date;
    }

    public function getTitle(): Domain\ValueObject\Title
    {
        return $this->title;
    }

    public function getUrl(): Domain\ValueObject\Url
    {
        return $this->url;
    }
}
