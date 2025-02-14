<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Task;

interface TaskFactoryInterface
{
    public function create(string $title): Task;
}