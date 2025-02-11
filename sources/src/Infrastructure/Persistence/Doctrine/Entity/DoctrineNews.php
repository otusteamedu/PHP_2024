<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "news")]
class DoctrineNews
{
    #[Id]
    #[Column]
    #[GeneratedValue]
    private ?int $id = null;

    #[Column(type: 'string')]
    private string $title;

    #[Column(type: 'string')]
    private string $url;

    #[Column(type: 'date')]
    private \DateTimeImmutable $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): DoctrineNews
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): DoctrineNews
    {
        $this->title = $title;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): DoctrineNews
    {
        $this->url = $url;
        return $this;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): DoctrineNews
    {
        $this->date = $date;
        return $this;
    }
}