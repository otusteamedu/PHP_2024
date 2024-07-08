<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\Status;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: TaskRepository::class)]
class Task implements \JsonSerializable
{
    public const REQUEST_FIELDS = [
        'name',
        'email',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: Types::STRING)]
    #[Assert\NotNull(message: 'The name must not be null')]
    #[Assert\NotBlank(message: 'The name must not be blank', allowNull: true)]
    private string $name;

    #[ORM\Column(name: 'email', type: Types::STRING)]
    #[Assert\NotNull(message: 'The email must not be null')]
    #[Assert\NotBlank(message: 'The email must not be blank', allowNull: true)]
    #[Assert\Email(message: 'The email is not valid')]
    private string $email;

    #[ORM\Column(name: 'status', type: Types::SMALLINT, enumType: Status::class)]
    private Status $status;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->status = Status::NEW;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function makeCompleted(): void
    {
        $this->status = Status::COMPLETED;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status->name,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt ? $this->updatedAt->format('Y-m-d H:i:s') : '',
        ];
    }
}
