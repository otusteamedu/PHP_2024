<?php
declare(strict_types=1);
namespace App\Domain\Entity;

class Product
{
    private string $type;
    private int $status = 1;
    private string $receipt;

    public function __construct(
        string $type,
        string $receipt
    ){
        $this->type = $type;
        $this->receipt = $receipt;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getReceipt(): string
    {
        return $this->receipt;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }



}