<?php

declare(strict_types=1);

namespace Service;

class Author
{
    private ?int $id = null;
    private string $name;
    private string $last_name;
    private ?string $patronymic = null;
    private \DateTimeImmutable $date_of_birth;
    private ?\DateTimeImmutable $date_of_death = null;
    private string $country;
    private string $gender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeImmutable $date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }

    public function getDateOfDeath(): ?\DateTimeImmutable
    {
        return $this->date_of_death;
    }

    public function setDateOfDeath(?\DateTimeImmutable $date_of_death): void
    {
        $this->date_of_death = $date_of_death;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }
}
