<?php

declare(strict_types=1);

namespace Application\Services;

use Domain\Entities\Ticket;
use Domain\Repositories\TicketRepositoryInterface;

class TicketService
{
    public function __construct(private TicketRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTickets(): array
    {
        return $this->repository->findAll();
    }

    public function getTicketById(int $id): ?Ticket
    {
        return $this->repository->findById($id);
    }

    public function createTicket(Ticket $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function updateTicket(Ticket $entity): string|false
    {
        return $this->repository->save($entity);
    }

    public function deleteTicket(int $id): void
    {
        $this->repository->delete($id);
    }
}
