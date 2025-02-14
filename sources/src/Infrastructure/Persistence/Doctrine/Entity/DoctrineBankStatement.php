<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "bankStatement")]
class DoctrineBankStatement
{
    #[Id]
    #[Column]
    #[GeneratedValue]
    private ?int $id = null;

    #[Column(type: 'integer')]
    private int $account;

    #[Column(type: 'string')]
    private string $title;

    #[Column(type: 'date')]
    private DateTime $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): DoctrineBankStatement
    {
        $this->id = $id;
        return $this;
    }

    public function getAccount(): int
    {
        return $this->account;
    }

    public function setAccount(int $account): DoctrineBankStatement
    {
        $this->account = $account;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): DoctrineBankStatement
    {
        $this->title = $title;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): DoctrineBankStatement
    {
        $this->date = $date;
        return $this;
    }
}
