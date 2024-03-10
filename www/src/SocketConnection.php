<?php

namespace Otus;

use Socket;

class SocketConnection
{
	private Socket|false $socket;

	public function __construct(private readonly string $socketPath)
	{
	}

	public function createSocket(): void
	{
		$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

		if (!$this->socket)
		{
			throw new \RuntimeException('Не удалось создать сокет: ' . socket_strerror(socket_last_error()));
		}
	}

	public function connect(): void
	{
		if (!socket_connect($this->socket, $this->socketPath))
		{
			throw new \RuntimeException('Не удалось подключиться к сокету: ' . socket_strerror(socket_last_error()));
		}
	}

	public function bind(): void
	{
		if (!socket_bind($this->socket, $this->socketPath))
		{
			throw new \RuntimeException('Не удалось привязать сокет: ' . socket_strerror(socket_last_error()));
		}
	}

	public function listen(int $backlog = 5): void
	{
		if (!socket_listen($this->socket, $backlog))
		{
			throw new \RuntimeException('Не удалось начать прослушивание сокета: ' . socket_strerror(socket_last_error()));
		}
	}

	public function accept(): \Socket
	{
		$clientSocket = socket_accept($this->socket);

		if ($clientSocket === false)
		{
			throw new \RuntimeException('Не удалось принять подключение: ' . socket_strerror(socket_last_error()));
		}

		return $clientSocket;
	}

	public function read(int $length = 2048): string|bool
	{
		return socket_read($this->socket, $length);
	}

	public function write(string $buffer): void
	{
		socket_write($this->socket, $buffer, strlen($buffer));
	}

	public function close(): void
	{
		socket_close($this->socket);
	}
}