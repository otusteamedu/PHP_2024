<?php

namespace Otus;

class Client
{
	private SocketConnection $socketConnection;

	public function __construct(private readonly ApplicationConfiguration $config)
	{
		$this->socketConnection = new SocketConnection($this->config->getByCode('socket_path'));
	}

	public function start(): void
	{
		$this->socketConnection->createSocket();
		$this->socketConnection->connect();

		echo 'Введите сообщение для отправки серверу: ';
		$input = fgets(STDIN);

		$this->socketConnection->write($_SERVER['HOSTNAME'] . ': ' . $input);

		$response = $this->socketConnection->read();
		echo 'Ответ сервера: ' . $response . PHP_EOL;

		$this->socketConnection->close();
	}
}