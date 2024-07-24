<?php

namespace App\Application\DTO;

readonly class DTO
{

    public function __construct(
        int $status,
        string $curFrom,
        string $curTo,
        string $amountFrom,
        string $amountTo,
        string $rate
    ){}

}
