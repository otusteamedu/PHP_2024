<?php

declare(strict_types=1);

namespace App\Application\Requests;

final readonly class ReportRequest
{
    public function __construct(public string $dateFrom, public string $dateTo)
    {
        //
    }

    public static function fromJson(?string $dataJson): self
    {
        if (empty($dataJson)) {
            throw new \InvalidArgumentException('Invalid data');
        }

        $dataArr = json_decode($dataJson, true);

        return self::fromArray($dataArr);
    }

    public static function fromArray(array $dataArr): self
    {
        if (!array_key_exists('dateFrom', $dataArr) || !array_key_exists('dateTo', $dataArr)) {
            throw new \InvalidArgumentException('Invalid data');
        }

        return new self($dataArr['dateFrom'], $dataArr['dateTo']);
    }

    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function toArray(): array
    {
        return [
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ];
    }
}
