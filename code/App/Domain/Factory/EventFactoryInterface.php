<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Condition;
use App\Domain\Entity\Event;

interface EventFactoryInterface
{
    public function create(int $priority, string $name, array $condition_list): Event;
}