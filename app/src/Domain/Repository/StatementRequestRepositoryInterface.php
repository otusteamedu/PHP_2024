<?php

declare(strict_types=1);

namespace Otus\Hw20\Domain\Repository;

use Otus\Hw20\Domain\Entity\StatementRequest;

interface StatementRequestRepositoryInterface
{
    public function save(StatementRequest $request): void;
    public function find(int $id): ?StatementRequest;
}
