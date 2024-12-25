<?php

namespace PaymentServiceBundle\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use PaymentServiceBundle\Domain\Entity\Interface\HasMetaTimestampsInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ps_payment')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete :false)]
class Payment implements HasMetaTimestampsInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\Column(name: 'user_id', type: 'bigint', nullable: false)]
    private int $userId;

    #[ORM\JoinTable(name: 'ps_payment_request')]
    #[ORM\JoinColumn(name: 'payment_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'request_uuid', referencedColumnName: 'uuid', unique: true)]
    #[ORM\ManyToMany(targetEntity: Request::class)]
    private Collection $requests;

    #[ORM\Column(name: 'amount', type: 'decimal', precision: '8', scale: '2', nullable: false)]
    private int $amount;

    #[ORM\Column(name: 'purpose', type: 'string', length: 100, nullable: false)]
    private string $purpose;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'deleted_at', type: 'datetime', nullable: true)]
    protected $deletedAt;

    public function __construct()
    {
        $this->requests = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRequests(): ?Collection
    {
        return $this->requests;
    }

    public function setRequests(?Collection $requests): void
    {
        $this->requests = $requests;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getPurpose(): string
    {
        return $this->purpose;
    }

    public function setPurpose(string $purpose): void
    {
        $this->purpose = $purpose;
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

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
