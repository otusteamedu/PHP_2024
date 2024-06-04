<?php

declare(strict_types=1);

namespace App\Requests;

readonly class Request
{
    public string $startDate;
    public string $endDate;
    public string $email;

    public function __construct(array $params)
    {
        $this->startDate = $params['start_date'] ?? '';
        $this->endDate = $params['end_date'] ?? '';
        $this->email = $params['email'] ?? '';
    }

    public function validate(): bool
    {
        if (empty($this->startDate) || empty($this->endDate) || empty($this->email)) {
            return false;
        }
        return true;
    }

    public function toArray(): array
    {
        return [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'email' => $this->email,
        ];
    }
}
