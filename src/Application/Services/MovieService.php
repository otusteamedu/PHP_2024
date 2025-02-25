<?php

declare(strict_types=1);

namespace Application\Services;

use Domain\Entities\Movie;
use Domain\Repositories\MovieRepositoryInterface;

class MovieService
{
    public function __construct(private MovieRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllMovies(): array
    {
        return $this->repository->findAll();
    }

    public function getMovieById(int $id): ?Movie
    {
        return $this->repository->findById($id);
    }

    public function createMovie(Movie $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function updateMovie(Movie $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function deleteMovie(int $id): void
    {
        $this->repository->delete($id);
    }
}
