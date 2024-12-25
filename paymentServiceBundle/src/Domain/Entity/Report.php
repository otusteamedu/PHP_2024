<?php

namespace PaymentServiceBundle\Domain\Entity;

use PaymentServiceBundle\Domain\Entity\Interface\HasMetaTimestampsInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;

#[ORM\Table(name: 'ps_report')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Report implements HasMetaTimestampsInterface
{
    #[ORM\Column(name: 'uuid', type: 'string', length: 36, unique: true)]
    #[ORM\Id]
    private string $uuid;

    #[ORM\Column(name: 'user_id', type: 'bigint', nullable: false)]
    private int $userId;

    #[ORM\Column(name: 'user_email', type: 'string', nullable: true)]
    private ?string $userEmail;

    #[ORM\Column(name: 'status', type: 'string', nullable: false, enumType: RequestStatusEnum::class)]
    private RequestStatusEnum $status;

    #[ORM\Column(name: 'period_begin', type: 'datetime', nullable: false)]
    private DateTime $periodBegin;

    #[ORM\Column(name: 'period_end', type: 'datetime', nullable: false)]
    private DateTime $periodEnd;

    #[ORM\Column(name: 'show_deleted', type: 'boolean', nullable: true)]
    private ?bool $showDeleted;

    #[ORM\Column(name: 'body', type: 'json', nullable: true)]
    private ?array $body;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserEmail(?string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function getStatus(): RequestStatusEnum
    {
        return $this->status;
    }

    public function setStatus(RequestStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function setShowDeleted(?bool $showDeleted): void
    {
        $this->showDeleted = $showDeleted;
    }

    public function getShowDeleted(): ?bool
    {
        return $this->showDeleted;
    }

    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function setPeriodBegin(DateTime $periodBegin): void
    {
        $this->periodBegin = $periodBegin;
    }

    public function getPeriodBegin(): DateTime
    {
        return $this->periodBegin;
    }

    public function setPeriodEnd(DateTime $periodEnd): void
    {
        $this->periodEnd = $periodEnd;
    }

    public function getPeriodEnd(): DateTime
    {
        return $this->periodEnd;
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

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
