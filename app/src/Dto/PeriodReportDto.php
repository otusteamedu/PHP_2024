<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PeriodReportDto
{
    #[Assert\Email]
    public string $email;
    public \DateTimeImmutable $startDate;
    public \DateTimeImmutable $endDate;

    public function __construct(string $email, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        $this->email = $email;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
