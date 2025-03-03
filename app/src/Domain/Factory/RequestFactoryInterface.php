<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Request;

interface RequestFactoryInterface
{
    public function create(string $holderName, string $holderEmail, string $status): Request;
}
