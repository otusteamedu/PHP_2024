<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Repositories\RequestOrmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestOrmRepository::class)]
#[ORM\Table(name: 'requests')]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $requesterName = null;
    #[ORM\Column(length: 255)]
    private ?string $requesterEmail = null;

    #[ORM\Column(type: "string", enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRequesterName(): ?string
    {
        return $this->requesterName;
    }

    public function setRequesterName(?string $requesterName): void
    {
        $this->requesterName = $requesterName;
    }

    public function getRequesterEmail(): ?string
    {
        return $this->requesterEmail;
    }

    public function setRequesterEmail(?string $requesterEmail): void
    {
        $this->requesterEmail = $requesterEmail;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus(?StatusEnum $status): void
    {
        $this->status = $status;
    }
}
