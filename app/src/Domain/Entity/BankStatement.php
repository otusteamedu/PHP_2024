<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Account;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\DateTimeReport;
use App\Domain\Constant\BankStatementStatus;
use App\Infrastructure\Repository\BankStatementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankStatementRepository::class)]
class BankStatement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?Account $account = null;

    #[ORM\Column(length: 50)]
    private ?Date $dateFrom = null;

    #[ORM\Column(length: 50)]
    private ?Date $dateTo = null;

    #[ORM\Column(length: 20)]
    private ?BankStatementStatus $status = null;

    #[ORM\Column(length: 50)]
    private $dateCreated = null;

    public function __construct($account, $dateFrom, $dateTo)
    {
        $this->account = $account;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->dateCreated = (new \DateTime('now'))->format("Y-m-d H:i:s");
        $this->status = BankStatementStatus::NEW;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getDateFrom(): Date
    {
        return $this->dateFrom;
    }

    public function getDateTo(): Date
    {
        return $this->dateTo;
    }

    public function getStatus(): BankStatementStatus
    {
        return $this->status;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }
}
