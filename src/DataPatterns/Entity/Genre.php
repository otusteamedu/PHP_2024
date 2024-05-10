<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\Entity;

use Closure;

class Genre
{
    private ?int $id = null;
    private Closure $moviesReference;
    private ?array $movies = null;

    public function __construct(
        private string $name
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Genre
    {
        $this->name = $name;
        return $this;
    }

    public function setMoviesReference(Closure $moviesReference): void
    {
        $this->moviesReference = $moviesReference;
    }

    /**
     * @return Movie[]
     */
    public function getMovies(): array
    {
        if ($this->movies === null) {
            $this->movies = ($this->moviesReference)();
        }

        return $this->movies;
    }
}
