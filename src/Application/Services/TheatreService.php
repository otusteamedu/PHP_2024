<?php

declare(strict_types=1);

namespace Application\Services;

use Domain\Entities\Theatre;
use Domain\Repositories\TheatreRepositoryInterface;

class TheatreService
{
    public function __construct(private TheatreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTheatres(): array
    {
        return $this->repository->findAll();
    }

    public function getTheatreById(int $id): ?Theatre
    {
        return $this->repository->findById($id);
    }

    public function createTheatre(Theatre $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function updateTheatre(Theatre $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function deleteTheatre(int $id): void
    {
        $this->repository->delete($id);
    }
}
