<?php

declare(strict_types=1);

namespace Hinoho\Battleship\Domain\RepositoryInterface;

interface StorageInterface
{
    public function connect();

    public function addMessage(string $message);

    public function getStatus(int $messageId);

    public function updateStatus(int $messageId, int $status);
}
