<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Repositories\AccountOrmRepository;
use App\Infrastructure\Repositories\StatementOrmRepository;
use App\Infrastructure\Repositories\TransactionOrmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatementOrmRepository::class)]
#[ORM\Table(name: 'statements')]
class Statement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $account_id = null;

    #[ORM\Column(type:"datetime")]
    private \DateTime|null $date_from = null;

    #[ORM\Column(type:"datetime")]
    private \DateTime|null $date_to = null;

    #[ORM\Column(type: "string", enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus( ?StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAccountId(): ?int
    {
        return $this->account_id;
    }

    public function setAccountId(?int $account_id): void
    {
        $this->account_id = $account_id;
    }

    public function getDateFrom(): ?\DateTime
    {
        return $this->date_from;
    }

    public function setDateFrom(?\DateTime $date_from): void
    {
        $this->date_from = $date_from;
    }

    public function getDateTo(): ?\DateTime
    {
        return $this->date_to;
    }

    public function setDateTo(?\DateTime $date_to): void
    {
        $this->date_to = $date_to;
    }







}
