<?php

namespace App\Domain\Entity;

class Transaction
{
    private readonly ?int $id;
    public function __construct(
        private int $sum,
        private string $account_from,
        private string $account_to,
        private string $datetime,
        private string $type,
        private string $status,
        private ?string $description,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAccountFrom(): string
    {
        return $this->account_from;
    }

    /**
     * @param string $account_from
     */
    public function setAccountFrom(string $account_from): void
    {
        $this->account_from = $account_from;
    }

    /**
     * @return string
     */
    public function getAccountTo(): string
    {
        return $this->account_to;
    }

    /**
     * @param string $account_to
     */
    public function setAccountTo(string $account_to): void
    {
        $this->account_to = $account_to;
    }

    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * @param string $date
     */
    public function setDatetime(string $date): void
    {
        $this->datetime = $date;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @param int $sum
     */
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }
}
