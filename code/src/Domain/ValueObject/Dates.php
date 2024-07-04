<?php

namespace App\Domain\ValueObject;

class Dates
{

    private string $dateFrom;
    private string $dateTo;
    public function __construct(
        string $dateFrom,
        string $dateTo
    ) {
        $this->assertRequestIsValid($dateFrom,$dateTo);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function get(): string
    {
        return "date_from={$this->dateFrom}&date_to={$this->dateTo}";
    }

    private function assertRequestIsValid(
        string $dateFrom,
        string $dateTo
    ): void
    {
        if (strlen($dateFrom) !== 10 && strlen($dateTo) !== 10) {
            throw new \InvalidArgumentException("Dates are invalid");
        }

        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateFrom) || !preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateTo)) {
            throw new \InvalidArgumentException("Dates are in the wrong format");
        }
    }
}