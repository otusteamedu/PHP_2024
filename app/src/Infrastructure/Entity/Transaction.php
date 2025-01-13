<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Repositories\AccountOrmRepository;
use App\Infrastructure\Repositories\TransactionOrmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionOrmRepository::class)]
#[ORM\Table(name: 'transactions')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $amount = null;
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column()]
    private ?int $account_id = null;

    #[ORM\Column()]
    private ?int $transaction_type_id = null;

    #[ORM\Column(type:"datetime")]
    private \DateTime|null $created_at = null;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }



    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getAccountId(): ?int
    {
        return $this->account_id;
    }

    public function setAccountId(?int $account_id): void
    {
        $this->account_id = $account_id;
    }



    public function getTransactionTypeId(): ?int
    {
        return $this->transaction_type_id;
    }

    public function setTransactionTypeId(?int $transaction_type_id): void
    {
        $this->transaction_type_id = $transaction_type_id;
    }

    #[ORM\OneToMany(targetEntity: Account::class, mappedBy: 'accounts')]
    private Account $account;

    public function getCategory(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
}
