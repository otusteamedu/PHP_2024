<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Lead;

interface LeadFactoryInterface
{
    public function create(string $userName, string $email, string $body): Lead;
}
