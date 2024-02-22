<?php

declare(strict_types=1);

namespace Kiryao\Sockchat;

use Exception;
use InvalidArgumentException;
use Kiryao\Sockchat\Chat\ClientChat;
use Kiryao\Sockchat\Chat\ServerChat;

class App
{
    private const ARGV_SERVER = 'server';
    private const ARGV_CLIENT = 'client';

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function run(): void
    {
        $arg = $_SERVER['argv'][1];

        if (empty($arg)) {
            throw new Exception('Argument missing. Please use ' . self::ARGV_SERVER . ' or ' . self::ARGV_CLIENT);
        }

        $chat = match ($arg) {
            self::ARGV_SERVER => new ServerChat(),
            self::ARGV_CLIENT => new ClientChat(),
            default => throw new InvalidArgumentException('Invalid argument. Please use ' . self::ARGV_SERVER . ' or ' . self::ARGV_CLIENT),
        };

        $chat->run();
    }
}
