<?php

declare(strict_types=1);

namespace App\Interface;

interface UnixSocketInterface
{
  public function create(): void;
  public function bind(): void;
  public function listen(): void;
  public function accept(): \Socket;
  public function read(\Socket $connect): string|false;
  public function getReadGenerator(?\Socket $connect): \Generator;
  public function connect(): void;
  public function write(string $message, \Socket $connect): void;
  public function close(\Socket $connect): void;
  public function unlink(): void;
}
