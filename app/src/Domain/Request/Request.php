<?php

namespace AnatolyShilyaev\App\Domain\Request;

class Request
{
    private string $dateFrom;
    private string $dateTo;

    public function __construct($dateFrom, $dateTo)
    {
        $this->assertUserDataIsValid($dateFrom, $dateTo);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    private function assertUserDataIsValid($dateFrom, $dateTo): void
    {
        if (!$dateFrom || !$dateTo) {
            throw new \InvalidArgumentException(
                "Задайте начальную и конечную даты"
            );
        }
    }

    public function getValue(): array
    {
        return [
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ];
    }
}
