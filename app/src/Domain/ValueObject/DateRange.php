<?php

declare(strict_types=1);

namespace Otus\Hw20\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class DateRange
{
    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $endDate;

    public function __construct(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        if ($startDate > $endDate) {
            throw new \InvalidArgumentException('Start date must be before end date');
        }
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): \DateTimeInterface { return $this->startDate; }
    public function getEndDate(): \DateTimeInterface { return $this->endDate; }
}
