<?php

namespace SergeyShirykalov\DataMapperSample\Entity;

class Driver
{
    public function __construct(
        private int $id,
        private int $carId,
        private string $name,
        private \DateTimeImmutable $birthDate,
        private string $licenseNumber,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Driver
    {
        $this->id = $id;
        return $this;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function setCarId(int $carId): Driver
    {
        $this->carId = $carId;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Driver
    {
        $this->name = $name;
        return $this;
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): Driver
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getLicenseNumber(): string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): Driver
    {
        $this->licenseNumber = $licenseNumber;
        return $this;
    }
}