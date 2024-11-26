<?php

namespace App\Domain\Gateway;

interface RequestAgeByNameGatewayInterface
{
    public function requestAge(string $name): ?int;
}
