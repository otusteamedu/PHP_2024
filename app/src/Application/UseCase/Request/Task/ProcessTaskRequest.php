<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request\Task;

use Symfony\Component\Validator\Constraints as Assert;

class ProcessTaskRequest
{
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    private mixed $id;

    public function __construct(mixed $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return (int)$this->id;
    }
}
