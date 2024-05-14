<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Url;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Embedded(class: Url::class)]
    private Url $url;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'])]
    private \DateTimeImmutable $date;

    public function __construct(
        Url $url,
        Name $name,
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->date = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Ignore]
    public function getUrl(): Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    #[Ignore]
    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    #[SerializedName('name')]
    public function getNameValue(): string
    {
        return $this->name->getValue();
    }

    #[SerializedName('url')]
    public function getUrlValue(): string
    {
        return $this->url->getValue();
    }
}
