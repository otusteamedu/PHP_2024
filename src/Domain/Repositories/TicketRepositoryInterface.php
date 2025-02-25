<?php

namespace Domain\Repositories;

use Domain\Entities\Ticket;

interface TicketRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): ?Ticket;

    public function save(Ticket $ticket): string|false;

    public function delete(int $id): void;
}
