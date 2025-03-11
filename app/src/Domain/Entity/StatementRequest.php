<?php

declare(strict_types=1);

namespace Otus\Hw20\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Otus\Hw20\Domain\ValueObject\DateRange;

#[ORM\Entity]
#[ORM\Table(name: "statement_requests")]
class StatementRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Embedded(class: DateRange::class, columnPrefix: false)]
    private DateRange $dateRange;

    #[ORM\Column(type: "string")]
    private string $status = 'pending';

    public function __construct(DateRange $dateRange)
    {
        $this->dateRange = $dateRange;
    }

    public function getId(): int { return $this->id; }
    public function getDateRange(): DateRange { return $this->dateRange; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }
}
