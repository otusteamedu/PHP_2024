<?php

namespace App\Domain\Entity;

use App\Domain\Interface\Entity\EntityInterface;
use App\Domain\ValueObject\Url;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;

#[ORM\Table(name: 'news')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class News implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    public function __construct(
        #[Embedded(class: Url::class)]
        private Url $url,
        #[ORM\Column(type: 'string', length: 300, nullable: false)]
        private string $title,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }
}
