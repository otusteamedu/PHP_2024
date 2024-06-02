<?php

declare(strict_types=1);

namespace App;

class Order
{
    private int $id;
    private int $sum;

    public function __construct(int $id, int $sum)
    {
        $this->id = $id;
        $this->sum = $sum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSum(): int
    {
        return $this->sum;
    }
}
