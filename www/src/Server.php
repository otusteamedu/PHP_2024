<?php

namespace Otus;

class Server
{
	private SocketConnection $socketConnection;

	public function __construct(private readonly ApplicationConfiguration $config)
	{
		$this->socketConnection = new SocketConnection($this->config->getByCode('socket_path'));

		pcntl_signal(SIGINT, [$this, 'cleanUp']);
		pcntl_signal(SIGTERM, [$this, 'cleanUp']);
	}

	public function start(): void
	{
		$this->deleteSocketFile();
		$this->socketConnection->createSocket();
		$this->socketConnection->bind();
		$this->socketConnection->listen();

		echo 'Сервер запущен и ожидает подключений...' . PHP_EOL;

		while (true)
		{
			pcntl_signal_dispatch();
			$clientSocket = $this->socketConnection->accept();
			$input = socket_read($clientSocket, 2048);
			echo $input . PHP_EOL;

			$msg = 'Received ' . strlen($input) . ' bytes';
			socket_write($clientSocket, $msg, strlen($msg));

			socket_close($clientSocket);

			$input = fgets(STDIN);

			if ($input === 'exit')
			{
				return;
			}
		}
	}

	public function stop(): void
	{
		$this->cleanUp();
	}

	private function cleanUp(): void
	{
		echo 'Очистка ресурсов и завершение работы...' . PHP_EOL;
		$this->socketConnection->createSocket();
		$this->socketConnection->close();
		$this->deleteSocketFile();

		exit;
	}

	private function deleteSocketFile(): void
	{
		if (file_exists($this->config->getByCode('socket_path')))
		{
			unlink($this->config->getByCode('socket_path'));
		}
	}
}