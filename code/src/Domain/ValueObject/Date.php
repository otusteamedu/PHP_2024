<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;

class Date
{
    private string $date;

    public function __construct(string $date)
    {
        $this->assertDateIsValid($date);
        $this->date = $date;
    }

    public function getValue(): string
    {
        return $this->date;
    }

    private function assertDateIsValid(string $date): void
    {
        if (!preg_match( '/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/', $date)) {
            throw new \InvalidArgumentException("Date does not correct!");
        }
    }

}