<?php

namespace Src\Domain\Factory;

use Src\Domain\Entity\Statement;

interface StatementFactoryInterface
{
    public function create(int $user_id, string $from_date, string $to_date): Statement;
}