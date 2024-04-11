<?php

declare(strict_types=1);

namespace hw17\DataMapper;

class MoviesSessions
{
    public function __construct(
        private int $id,
        private int $hallsId,
        private int $movieId,
        private int $startTime,
        private int $endTime
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
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->endTime;
    }

    /**
     * @return int
     */
    public function getHallsId(): int
    {
        return $this->hallsId;
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
}
