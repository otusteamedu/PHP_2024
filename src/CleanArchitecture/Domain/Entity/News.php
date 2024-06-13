<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Entity;

use AlexanderGladkov\CleanArchitecture\Domain\ValueObject\Url;
use AlexanderGladkov\CleanArchitecture\Domain\ValueObject\NewsTitle;
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
    private ?int $id = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIMETZ_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $createdAt;

    #[Assert\Valid]
    #[ORM\Embedded(class: Url::class, columnPrefix: false)]
    private Url $url;

    #[Assert\Valid]
    #[ORM\Embedded(class: NewsTitle::class, columnPrefix: false)]
    private NewsTitle $title;

    public function __construct(Url $url, NewsTitle $title)
    {
        $this->url = $url;
        $this->title = $title;
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getTitle(): NewsTitle
    {
        return $this->title;
    }

    public function changeTitle(NewsTitle $title): void
    {
        $this->title = $title;
        // Можно также установить дату, если считаем, что дата это момент парсинга страницы, а не дата создания
        // записи в БД.
        //$this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}
