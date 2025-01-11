<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Repositories\AccountOrmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountOrmRepository::class)]
#[ORM\Table(name: 'accounts')]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $holderName = null;
    #[ORM\Column(length: 255)]
    private ?string $holderEmail = null;

    public function setHolderName(?string $holderName): void
    {
        $this->holderName = $holderName;
    }

    public function setHolderEmail(?string $holderEmail): void
    {
        $this->holderEmail = $holderEmail;
    }

    public function getHolderName(): ?string
    {
        return $this->holderName;
    }

    public function getHolderEmail(): ?string
    {
        return $this->holderEmail;
    }


    public function getId(): ?int
    {
        return $this->id;
    }
}
