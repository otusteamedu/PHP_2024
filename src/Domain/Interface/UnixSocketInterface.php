<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface UnixSocketInterface
{
    public function create(): self;
    public function bind(): self;
    public function listen(): self;
    public function connect(): self;

    public function accept(): \Socket;
    public function getReadGenerator(?\Socket $connect): \Generator;
    public function write(string $message, \Socket $connect): void;
    public function close(\Socket $connect): void;
    public function unlink(): void;
}
