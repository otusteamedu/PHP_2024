<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Url;
use Carbon\Carbon;

class News
{
    private ?int $id = null;

    public function __construct(
        private readonly Url  $url,
        private readonly Name $name,
        private readonly ?Carbon $createdAt
    )
    {
        //
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function getCreatedAtByFormat($format = 'Y-m-d H:i:s'): string
    {
        return $this->createdAt->format($format);
    }
}
