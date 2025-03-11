<?php

declare(strict_types=1);

namespace Otus\Hw20\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Otus\Hw20\Domain\Entity\StatementRequest;
use Otus\Hw20\Domain\Repository\StatementRequestRepositoryInterface;

class StatementRequestRepository implements StatementRequestRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(StatementRequest $request): void
    {
        $this->em->persist($request);
        $this->em->flush();
    }

    public function find(int $id): ?StatementRequest
    {
        return $this->em->find(StatementRequest::class, $id);
    }
}
