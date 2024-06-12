<?php

declare(strict_types=1);

namespace App\Domain\Image;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'images')]
class Image
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private ?string $id;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $path;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\Column(type: 'string')]
    private string $status;

    /**
     * @param string $description
     * @param string $status
     * @param string|null $id
     * @param string|null $path
     */
    public function __construct(string $description, string $status, string $id = null, string $path = null)
    {
        $this->path = $path;
        $this->description = $description;
        $this->status = $status;
        $this->id = $id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
