<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;

class BankStatement
{
    private ?int $id = null;

    public function __construct(
        private int      $account,
        private string   $title,
        private DateTime $date
    )
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): BankStatement
    {
        $this->id = $id;
        return $this;
    }

    public function getAccount(): int
    {
        return $this->account;
    }

    public function setAccount(int $account): BankStatement
    {
        $this->account = $account;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BankStatement
    {
        $this->title = $title;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): BankStatement
    {
        $this->date = $date;
        return $this;
    }
}