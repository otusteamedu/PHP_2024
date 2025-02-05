<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interface\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'purchase')]
#[ORM\Entity]
class Purchase implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

//    #[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'purchases')]
//    private Message $message;

    #[ORM\Column(name: 'title', type: 'string')]
    private string $title;

    #[ORM\Column(name: 'is_purchased', type: 'boolean', nullable: true)]
    private bool $isPurchased;

    #[ORM\Column(name: 'telegram_user_id', type: 'bigint', nullable: true)]
    private int $telegramUserId;

    #[ORM\Column(name: 'is_bot', type: 'boolean', nullable: true)]
    private bool $isBot;

    #[ORM\Column(name: 'first_name', type: 'string', nullable: true)]
    private string $firstName;

    #[ORM\Column(name: 'user_name', type: 'string', nullable: true)]
    private string $userName;

    #[ORM\Column(name: 'date', type: 'integer', nullable: true)]
    private int $date;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getIsPurchased(): bool
    {
        return $this->isPurchased;
    }

    public function setIsPurchased(bool $isPurchased): void
    {
        $this->isPurchased = $isPurchased;
    }

    public function getTelegramUserId(): int
    {
        return $this->telegramUserId;
    }

    public function seTelegramUserId(int $telegramUserId): void
    {
        $this->telegramUserId = $telegramUserId;
    }

    public function getIsBot(): bool
    {
        return $this->isBot;
    }

    public function setIsBot(bool $isBot): void
    {
        $this->isBot = $isBot;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): void
    {
        $this->date = $date;
    }
}
