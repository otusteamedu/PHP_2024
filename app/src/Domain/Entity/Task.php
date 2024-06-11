<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\TaskStatus;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'public.tasks')]
class Task
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $body;

    #[Assert\NotNull]
    #[ORM\Column(
        type: Types::STRING,
        length: 255,
        nullable: false,
        enumType: TaskStatus::class
    )]
    private TaskStatus $status;

    public function __construct(string $body)
    {
        $this->body = trim($body);
        $this->status = TaskStatus::QUEUED;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function changeStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }
}
