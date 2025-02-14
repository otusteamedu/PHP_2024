<?php

declare(strict_types=1);

namespace App\Domain\Event;

readonly class StatementPersistedEvent
{
    public function __construct(
        private int       $account,
        private \DateTime $dateFrom,
        private \DateTime $dateTo
    )
    {
    }

    public function getAccount(): int
    {
        return $this->account;
    }

    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }
}
