<?php

declare(strict_types=1);

namespace SergeyShirykalov\DataMapperSample\Entity;

use SergeyShirykalov\DataMapperSample\Proxy\DriverProxy;

class Car
{
    public function __construct(
        private int $id,
        private string $mark,
        private string $model,
        private string $vin,
        private PTS $pts,
        private ?DriverProxy $driver = null
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMark(): string
    {
        return $this->mark;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function getPts(): PTS
    {
        return $this->pts;
    }

    public function getDriver(): ?DriverProxy
    {
        return $this->driver;
    }

    public function setId(int $id): Car
    {
        $this->id = $id;
        return $this;
    }

    public function setMark(string $mark): Car
    {
        $this->mark = $mark;
        return $this;
    }

    public function setModel(string $model): Car
    {
        $this->model = $model;
        return $this;
    }

    public function setVin(string $vin): Car
    {
        $this->vin = $vin;
        return $this;
    }

    public function setPts(PTS $pts): Car
    {
        $this->pts = $pts;
        return $this;
    }

    public function setDriver(?DriverProxy $driver): Car
    {
        $this->driver = $driver;
        return $this;
    }

}