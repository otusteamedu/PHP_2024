<?php

namespace App\Application\Interface;

use App\Domain\Entity\StatementRequest;

interface QueueAddMsgInterface
{
    public function add(StatementRequest $request): void;
    public function closeConnection(): void;
}