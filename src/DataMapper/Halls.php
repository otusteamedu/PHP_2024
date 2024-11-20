<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class Halls
{
    public function __construct(
        private int $id,
        private string $hallName,
        private int $numberOfSeats,
        private int $isPremium
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHallName(): string
    {
        return $this->hallName;
    }

    /**
     * @return int
     */
    public function getIsPremium(): int
    {
        return $this->isPremium;
    }

    /**
     * @return int
     */
    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $hallName
     */
    public function setHallName(string $hallName): self
    {
        $this->hallName = $hallName;

        return $this;
    }

    /**
     * @param int $isPremium
     */
    public function setIsPremium(int $isPremium): self
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    /**
     * @param int $numberOfSeats
     */
    public function setNumberOfSeats(int $numberOfSeats): self
    {
        $this->numberOfSeats = $numberOfSeats;

        return $this;
    }
}
