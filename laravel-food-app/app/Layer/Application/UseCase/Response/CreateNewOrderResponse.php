<?php

declare(strict_types=1);

namespace App\Layer\Application\UseCase\Response;

class CreateNewOrderResponse
{
    public function __construct
    (
        public string $order,
    )
    {}
}
