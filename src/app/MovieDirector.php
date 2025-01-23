<?php

declare(strict_types=1);

namespace App;

class MovieDirector
{
    private ?int $id = null;
    private string $name;
    private string $origName;
    private \DateTimeImmutable $dateOfBirth;

    public function __construct($id, $name, $orig_name, $date_of_birth)
    {
        $this->id = $id;
        $this->name = $name;
        $this->origName = $orig_name;
        $this->dateOfBirth = \DateTimeImmutable::createFromFormat("Y-m-d", $date_of_birth);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOrigName(): string
    {
        return $this->origName;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'origName' => $this->origName,
            'dateOfBirth' => $this->dateOfBirth->format("Y-m-d"),
        ];
    }
}
