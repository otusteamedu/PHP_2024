<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Dates;

class StatementRequest
{

    private string $statementRequest;
    private ?int $status = null;

    public function __construct(
        Dates $interval
    ) {
        $this->statementRequest = $interval->get();
    }

    public function get(): string
    {
        return $this->statementRequest;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }


}