<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Entity;

use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'public.news')]
final class News
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'created_at', type: Types::DATETIMETZ_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Url]
    private string $url;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max:255)]
    private string $title;

    public function __construct(string $url, string $title)
    {
        $this->url = $url;
        $this->title = $title;
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
