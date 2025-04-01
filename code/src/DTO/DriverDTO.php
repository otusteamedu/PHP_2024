<?php

namespace SergeyShirykalov\DataMapperSample\DTO;

class DriverDTO
{
    public function __construct(
        public int $carId,
        public string $name,
        public string $birthDate,
        public string $licenseNumber,
    )
    {
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['carId'],
            $array['name'],
            $array['birthDate'],
            $array['licenseNumber'],
        );
    }
}