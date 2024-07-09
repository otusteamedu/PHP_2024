<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Uuid;

class News
{
    private int $id;

    public function __construct(
        private Url $url,
        private Title $title,
        private Uuid $uuid,
        private \DateTime $date = new \DateTime()
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }
}
