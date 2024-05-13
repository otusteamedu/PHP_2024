<?php

declare(strict_types=1);

namespace App\Chat;

use App\Config\SocketConfig;
use App\Interfaces\Chat\AdapterInterface;
use App\Network\SocketManager;
use Exception;

class AdapterFactory
{
    public function make(string $type): AdapterInterface
    {
        $class = match ($type) {
            'server' => Server::class,
            'client' => Client::class,
            default => throw new Exception('Unknown chat type', CLD_EXITED),
        };

        return new $class(new SocketManager(), new SocketConfig());
    }
}