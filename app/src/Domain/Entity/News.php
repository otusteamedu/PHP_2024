<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Domain\Entity;

use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Title;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;

    public function __construct(
        private Url $url,
        private Title $title,
        private \DateTimeInterface $date = new \DateTime()
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }
}
