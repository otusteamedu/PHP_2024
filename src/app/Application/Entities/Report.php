<?php

declare(strict_types=1);

namespace App\Application\Entities;

readonly class Report
{
    public function __construct(
        private string $dateFrom,
        private string $dateTo,
        private array  $data,
    )
    {
        //
    }

    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTitle(): string
    {
        return static::makeTitle($this->dateFrom, $this->dateTo);
    }

    public function getBody(): string
    {
        return static::makeBody($this->data);
    }

    public function getFull(): string
    {
        return $this->getTitle() . PHP_EOL . $this->getBody();
    }

    public function __toString(): string
    {
        return $this->getFull();
    }

    protected static function makeTitle(string $dateFrom, string $dateTo): string
    {
        return "Report {$dateFrom} - {$dateTo}";
    }

    protected static function makeBody(array $data): string
    {
        return implode(',' . PHP_EOL, $data);
    }
}
