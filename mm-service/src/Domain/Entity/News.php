<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;
use App\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;
    private string $title;
    private Url $url;
    private DateTimeImmutable $createdAt;

    /**
     * @param string $title
     * @param Url $url
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(string $title, Url $url, DateTimeImmutable $createdAt)
    {
        $this->title = $title;
        $this->url = $url;
        $this->createdAt = $createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
