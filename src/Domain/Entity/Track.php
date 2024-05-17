<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Genre;
use App\Domain\ValueObject\TrackDuration;

class Track
{
    private int $id;

    public function __construct(
        private string $author,
        private Genre $genre,
        private TrackDuration $duration,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDuration(): TrackDuration
    {
        return $this->duration;
    }

    public function setDuration(TrackDuration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public static function create(string $author, string $genre, int $duration): self
    {
        return new self(
            $author,
            new Genre($genre),
            new TrackDuration($duration)
        );
    }
}
