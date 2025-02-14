<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Entity\Task;
use App\Domain\Factory\TaskFactoryInterface;
use App\Domain\ValueObject\Title;

class TaskFactory implements TaskFactoryInterface
{

    public function create(string $title): Task
    {
        return new Task(
            (new Title($title))->getValue()
        );
    }
}