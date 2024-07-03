<?php

namespace App\Domain\ValueObject;

class Dates
{
    private string $dates;

    public function __construct(
        string $dateFrom,
        string $dateTo
    ) {
        $this->dates = $this->assertRequestIsValid($dateFrom,$dateTo);
    }

    private function assertRequestIsValid(string $dateFrom, string $dateTo): string
    {
        if (strlen($dateFrom) !== 10 && strlen($dateTo) !== 10) {
            throw new \InvalidArgumentException("Dates are invalid");
        }

        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateFrom) || !preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateTo)) {
            throw new \InvalidArgumentException("Dates are in the wrong format");
        }
        return "date_from={$dateFrom}&date_to={$dateTo}";
    }
}