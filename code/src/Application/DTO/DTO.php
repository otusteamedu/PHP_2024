<?php
declare(strict_types=1);

namespace App\Application\DTO;

readonly class DTO
{
    public function __construct(
        public string $request
    ){}

}