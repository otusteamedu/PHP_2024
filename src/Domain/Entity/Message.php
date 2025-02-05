<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Interface\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'message')]
#[ORM\Entity]
#[ORM\Index(name: 'id_chat_id__index', columns: ['id', 'chat_id'])]
class Message implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'update_id', type: 'bigint')]
    private int $updateId;

    #[ORM\Column(name: 'chat_id', type: 'bigint')]
    private int $chatId;

    #[ORM\Column(name: 'message_id', type: 'integer')]
    private int $messageId;

    #[ORM\Column(name: 'telegram_user_id', type: 'bigint')]
    private int $telegramUserId;

    #[ORM\Column(name: 'is_bot', type: 'boolean')]
    private bool $isBot;

    #[ORM\Column(name: 'first_name', type: 'string')]
    private string $firstName;

    #[ORM\Column(name: 'user_name', type: 'string')]
    private string $userName;

    #[ORM\Column(name: 'text', type: 'string')]
    private string $text;

    #[ORM\JoinTable(name: 'message_purchase')]
    #[ORM\JoinColumn(name: 'message_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'purchase_id', referencedColumnName: 'id')]
//    #[ORM\ManyToMany(targetEntity: Purchase::class, inversedBy: 'message')]
    #[ORM\ManyToMany(targetEntity: Purchase::class)]
    private ?Collection $purchases;

    #[ORM\Column(name: 'date', type: 'integer')]
    private int $date;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function setUpdateId(int $updateId): void
    {
        $this->updateId = $updateId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function setMessageId(int $messageId): void
    {
        $this->messageId = $messageId;
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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getPurchases(): ?Collection
    {
        return $this->purchases;
    }

    public function setPurchases(?Collection $purchases): void
    {
        $this->purchases = $purchases;
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
