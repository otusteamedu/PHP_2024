<?php

namespace SergeyShirykalov\DataMapperSample\Proxy;

use SergeyShirykalov\DataMapperSample\Entity\Driver;
use SergeyShirykalov\DataMapperSample\Mapper\DriverMapper;

class DriverProxy
{
    private ?Driver $driver = null;

    public function __construct(
        private readonly DriverMapper $mapper,
        private readonly int          $carId)
    {
    }

    private function loadDriverIfNeeded(): void
    {
        if ($this->driver === null) {
            $this->driver = $this->mapper->findByCarId($this->carId);
        }
    }

    public function getId(): int
    {
        $this->loadDriverIfNeeded();
        return $this->driver->getId();
    }

    public function setId(int $id): Driver
    {
        $this->loadDriverIfNeeded();
        return $this->driver->setId($id);
    }

    public function getName(): string
    {
        $this->loadDriverIfNeeded();
        return $this->driver->getName();
    }

    public function setName(string $name): Driver
    {
        $this->loadDriverIfNeeded();
        return $this->driver->setName($name);
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        $this->loadDriverIfNeeded();
        return $this->driver->getBirthDate();
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): Driver
    {
        $this->loadDriverIfNeeded();
        return $this->driver->setBirthDate($birthDate);
    }

    public function getLicenseNumber(): string
    {
        $this->loadDriverIfNeeded();
        return $this->driver->getLicenseNumber();
    }

    public function setLicenseNumber(string $licenseNumber): Driver
    {
        $this->loadDriverIfNeeded();
        return $this->driver->setLicenseNumber($licenseNumber);
    }
}
