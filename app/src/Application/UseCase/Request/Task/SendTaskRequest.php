<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request\Task;

use Symfony\Component\Validator\Constraints as Assert;

class SendTaskRequest
{
    #[Assert\NotNull]
    #[Assert\Type('string')]
    private mixed $body;

    public function __construct(mixed $body)
    {
        $this->body = $body;
    }

    public function getBody(): string
    {
        return (string)$this->body;
    }
}
