<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\Entity;

use Closure;
use DateTime;

class Movie
{
    private ?int $id = null;
    private Closure $genresReference;
    private ?array $genres = null;

    public function __construct
    (
        private string $title,
        private DateTime $releaseDate,
        private int $duration,
        private ?string $description = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    public function getReleaseDate(): DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTime $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): Movie
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Movie
    {
        $this->description = $description;
        return $this;
    }

    public function setGenresReference(Closure $genresReference): void
    {
        $this->genresReference = $genresReference;
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        if ($this->genres === null) {
            $this->genres = ($this->genresReference)();
        }

        return $this->genres;
    }
}
