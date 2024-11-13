<?php

declare(strict_types=1);

namespace App\Application\Observer;

class ProductStatus
{
    protected $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getEventName(): string
    {
        return $this->status;
    }
}
