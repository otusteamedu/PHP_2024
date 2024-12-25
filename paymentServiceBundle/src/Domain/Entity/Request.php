<?php

namespace PaymentServiceBundle\Domain\Entity;

use PaymentServiceBundle\Domain\Entity\Interface\HasMetaTimestampsInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestStatusEnum;
use PaymentServiceBundle\Application\Doctrine\EnumTypes\RequestTypeEnum;

#[ORM\Table(name: 'ps_request')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Request implements HasMetaTimestampsInterface
{
    #[ORM\Column(name: 'uuid', type: 'string', length: 36, unique: true)]
    #[ORM\Id]
    private string $uuid;

    #[ORM\Column(name: 'parent_request', type: 'string', nullable: true)]
    private ?string $parentRequest = null;

    #[ORM\Column(name: 'user_id', type: 'bigint', nullable: false)]
    private int $userId;

    #[ORM\Column(name: 'type', type: 'string', nullable: false, enumType: RequestTypeEnum::class)]
    private RequestTypeEnum $type;

    #[ORM\Column(name: 'status', type: 'string', nullable: false, enumType: RequestStatusEnum::class)]
    private RequestStatusEnum $status;

    #[ORM\Column(name: 'amount', type: 'decimal', precision: '8', scale: '2', nullable: true)]
    private ?int $amount;

    #[ORM\Column(name: 'purpose', type: 'string', length: 100, nullable: true)]
    private ?string $purpose;

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

    public function getParentRequest(): ?string
    {
        return $this->parentRequest;
    }

    public function setParentRequest(?string $parentRequest): void
    {
        $this->parentRequest = $parentRequest;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getType(): RequestTypeEnum
    {
        return $this->type;
    }

    public function setType(RequestTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(?string $purpose): void
    {
        $this->purpose = $purpose;
    }

    public function getStatus(): RequestStatusEnum
    {
        return $this->status;
    }

    public function setStatus(RequestStatusEnum $status): void
    {
        $this->status = $status;
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
