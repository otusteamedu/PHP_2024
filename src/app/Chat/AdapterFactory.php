<?php

declare(strict_types=1);

namespace App\Chat;

use App\Config\SocketConfig;
use App\Exceptions\Chat\AdapterException;
use App\Interfaces\Chat\AdapterInterface;
use App\Network\SocketManager;

final class AdapterFactory
{
    public function make(string $type): AdapterInterface
    {
        $class = match ($type) {
            'server' => Server::class,
            'client' => Client::class,
            default => throw AdapterException::unknownType($type),
        };

        return new $class(new SocketManager(), new SocketConfig());
    }
}
