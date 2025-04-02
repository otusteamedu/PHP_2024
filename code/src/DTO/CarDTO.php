<?php

namespace SergeyShirykalov\DataMapperSample\DTO;

class CarDTO
{
    public function __construct(
        public string $mark,
        public string $model,
        public string $vin,
        public string $ptsNumber,
        public string $ptsDate,
    )
    {
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['mark'],
            $array['model'],
            $array['vin'],
            $array['ptsNumber'],
            $array['ptsDate']
        );
    }
}