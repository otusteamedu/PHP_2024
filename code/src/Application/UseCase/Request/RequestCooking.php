<?php
declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class RequestCooking
{
    public function __construct(
        private int $status
    ){}
}
