<?php

namespace App\Domain\Entity;

use App\Domain\Entity\ValueObject\Name;
use App\Domain\Entity\ValueObject\Url;
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

    public function toArray(): array
    {
        return [
          'id' => $this->id,
          'url' => $this->url->getUrl(),
          'name' => $this->name->getName(),
          'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
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
}
