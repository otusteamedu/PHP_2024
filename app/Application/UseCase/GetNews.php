<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Contract\RepositoryInterface;

final class GetNews
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    public function __invoke(): array
    {
        return $this->repository->getAll();
    }
}
