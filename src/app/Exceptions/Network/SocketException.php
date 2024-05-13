<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Exception;
use Socket;

class SocketException extends Exception
{
    public static function extensionNotLoaded(): self
    {
        return new self('Required [sockets] extension is not loaded.');
    }

    public static function couldNotCreate(): self
    {
        return new self('Could not create socket: ' . self::getErrorMessage());
    }

    public static function connectionIsNotAcceptable(Socket $socket): self
    {
        return new self('Could not accept socket connection: ' . self::getErrorMessage($socket));
    }

    public static function unprocessableFunction(string $function, Socket $socket): self
    {
        $message = sprintf(
            'Could not process function [%s]: %s',
            $function,
            self::getErrorMessage($socket)
        );

        return new self($message);
    }

    private static function getErrorMessage(?Socket $socket = null): string
    {
        return socket_strerror(socket_last_error($socket));
    }
}
