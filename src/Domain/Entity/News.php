<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'news')]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Embedded(class: Url::class, columnPrefix: false)]
    private Url $url;

    #[ORM\Embedded(class: Title::class, columnPrefix: false)]
    private Title $title;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $date;

    public function __construct(Url $url, Title $title, \DateTime $date)
    {
        $this->url = $url;
        $this->title = $title;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }
}
