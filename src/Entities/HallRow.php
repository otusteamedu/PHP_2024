<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Entities;

use Closure;

class HallRow
{
    private int $id;

    private int $hallId;

    private int $number;

    private int $capacity;

    /**
     * @var Hall
     */
    private Hall $hall;

    private Closure $repoRef;

    public function __construct(
        int $id,
        int $hallId,
        int $number,
        int $capacity
    ) {
        $this->id = $id;
        $this->hallId = $hallId;
        $this->number = $number;
        $this->capacity = $capacity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getHallId(): int
    {
        return $this->hallId;
    }

    public function setHallId(int $hallId): self
    {
        $this->hallId = $hallId;

        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @param Closure $repoRef
     */
    public function setRepoReference(Closure $repoRef): void
    {
        $this->repoRef = $repoRef;
    }

    /**
     * @return Hall
     */
    public function getHall(): Hall
    {
        if (!isset($this->hall)) {
            $this->hall = ($this->repoRef)();
        }

        return $this->hall;
    }
}
