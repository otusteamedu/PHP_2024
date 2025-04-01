<?php

namespace SergeyShirykalov\DataMapperSample\Entity;

class PTS
{
    private string $number;
    private \DateTimeImmutable $date;

    /**
     * @param string $number
     * @param string $date
     * @throws \Exception
     */
    public function __construct(string $number, string $date)
    {
        self::assertStringNotEmpty($number);
        self::assertStringNotEmpty($date);
        $this->number = $number;
        $this->date = new \DateTimeImmutable($date);
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    private static function assertStringNotEmpty(string $str): void
    {
        if (empty($str)) {
            throw new \Exception('String is empty');
        }
    }
}