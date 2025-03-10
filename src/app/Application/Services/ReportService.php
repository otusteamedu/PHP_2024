<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Entities\Report;

readonly class ReportService
{
    private string $dateFrom;
    private string $dateTo;


    public function setDateFrom(string $dateFrom): static
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function setDateTo(string $dateTo): static
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function create(): Report
    {
        if (empty($this->dateFrom) || empty($this->dateTo)) {
            throw new \InvalidArgumentException('Invalid report data');
        }

        // Getting report data
        $mockData = static::getData($this->dateFrom, $this->dateTo);

        return new Report($this->dateFrom, $this->dateTo, $mockData);
    }

    protected static function getData(string $dateFrom, string $dateTo): array
    {
        return [
            'Transaction: 983745',
            'Transaction: 325874',
            'Transaction: 730148',
            'Transaction: 544860',
        ];
    }
}
