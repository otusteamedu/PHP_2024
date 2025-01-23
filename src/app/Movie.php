<?php

declare(strict_types=1);

namespace App;

final class Movie
{
    private ?int $id = null;
    private string $title;
    private string $origTitle;
    private string $genre;
    private int $year;
    private int $duration;
    private float $rating;
    private int $movie_director_id;
    private ?MovieDirector $director = null;

    public function __construct($id, $title, $orig_title, $genre, $year, $duration, $rating, $movie_director_id, $director = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->origTitle = $orig_title;
        $this->genre = $genre;
        $this->year = $year;
        $this->duration = $duration;
        $this->rating = (float)$rating;
        $this->movie_director_id = $movie_director_id;
        $this->director = $director;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOrigTitle(): string
    {
        return $this->origTitle;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getDirectorId(): int
    {
        return $this->movie_director_id;
    }

    public function getDirector(): ?MovieDirector
    {
        return $this->director;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'orig_title' => $this->origTitle,
            'genre' => $this->genre,
            'year' => $this->year,
            'duration' => $this->duration,
            'rating' => $this->rating,
            'movie_director_id' => $this->movie_director_id,
            'director' => $this->director?->toArray(),
        ];
    }
}
