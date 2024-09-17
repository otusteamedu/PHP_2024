<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;

    public function __construct(
        private Date $date,
        private Url $url,
        private Title $title,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDate(): Date
    {
        return $this->date;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
