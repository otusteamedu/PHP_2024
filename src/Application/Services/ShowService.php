<?php

declare(strict_types=1);

namespace Application\Services;

use Domain\Entities\Show;
use Domain\Repositories\ShowRepositoryInterface;

class ShowService
{
    public function __construct(private ShowRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllShows(): array
    {
        return $this->repository->findAll();
    }

    public function getShowById(int $id): ?Show
    {
        return $this->repository->findById($id);
    }

    public function createShow(Show $entity): void
    {
        $this->repository->save($entity);
    }

    public function updateShow(Show $entity): void
    {
        $this->repository->save($entity);
    }

    public function deleteShow(int $id): void
    {
        $this->repository->delete($id);
    }
}
