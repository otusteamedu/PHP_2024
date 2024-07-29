<?php

namespace App\Infrastructure\RateManager;

class RateManager
{
    public function __invoke(): array
    {
        // Implement rate logic here
        return [
            'USD' => 1.1,
            'EUR' => 0.9,
        ];
    }

}
