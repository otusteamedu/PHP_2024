<?php

declare(strict_types=1);

namespace hw17\DataMapper;

use Closure;

class MoviesSessions
{
    /** @var array Halls $halls */
    private array $halls = [];

    /** @var array Movies $movies */
    private array $movies = [];

    /** @var Closure $movieReference */
    private Closure $movieReference;

    /** @var Closure $hallReference */
    private Closure $hallReference;

    public function __construct(
        private int $id,
        private int $hallId,
        private int $movieId,
        private int $startTime,
        private int $endTime
    ) {
    }

    /**
     * @param Closure $reference
     * @return void
     */
    public function setMovieReference(Closure $reference): void
    {
        $this->movieReference = $reference;
    }

    /**
     * @param Closure $reference
     * @return void
     */
    public function setHallReference(Closure $reference): void
    {
        $this->hallReference = $reference;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->endTime;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->startTime;
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
     * @param int $endTime
     */
    public function setEndTime(int $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @param int $hallsId
     */
    public function setHallsId(int $hallsId): self
    {
        $this->hallsId = $hallsId;

        return $this;
    }

    /**
     * @param int $movieId
     */
    public function setMovieId(int $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    /**
     * @param int $startTime
     */
    public function setStartTime(int $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }


    public function getHalls(): array
    {
        if (!isset($this->halls)) {
            $this->halls = ($this->hallReference)();
        }

        return $this->halls;
    }

    public function getMovies(): array
    {
        if (!isset($this->movies)) {
            $this->movies = ($this->movieReference)();
        }

        return $this->movies;
    }
}
