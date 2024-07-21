<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\ResponseDTO\ClearAllResponse;
use App\Domain\Repository\IRepository;

readonly class ClearAll
{
    public function __construct(private IRepository $repository)
    {
    }
    public function __invoke(): ClearAllResponse
    {
        return $this->repository->clearAll();
    }
}
