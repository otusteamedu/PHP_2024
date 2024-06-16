<?php

declare(strict_types=1);

namespace App\Rabbitmq\Message;

use App\Dto\PeriodReportDto;

readonly class BankReportMessage implements \JsonSerializable, MessageInterface
{
    public function __construct(
        public string $email,
        public string $startDate,
        public string $endDate,
    ) {
    }

    public static function creteFromPeriodReportDto(PeriodReportDto $dto): self
    {
        return new self(
            $dto->email,
            $dto->startDate->format('Y-m-d'),
            $dto->endDate->format('Y-m-d'),
        );
    }

    public static function createFromArray(array $message): self
    {
        return new self(
            $message['email'],
            $message['startDate'],
            $message['endDate'],
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'email' => $this->email,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'className' => static::class,
        ];
    }

    public function getMessageClass(): string
    {
        return static::class;
    }
}
