<?php

declare(strict_types=1);

namespace Module\News\Domain\Entity;

use Core\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use Module\News\Domain\ValueObject\Title;
use Module\News\Domain\ValueObject\Url;

final class News
{
    private DateTimeInterface $date;
    private Status $status;

    public function __construct(
        private readonly Uuid $id,
        private readonly Url $url,
        private readonly Title $title,
    ) {
        $this->date = new DateTimeImmutable();
        $this->status = Status::New;
    }

    public function getId(): string
    {
        return $this->id->getValue();
    }

    public function getDate(): DateTimeInterface
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }
}
