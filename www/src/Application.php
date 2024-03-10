<?php

namespace Otus;

class Application
{
	private ApplicationConfiguration $config;

	public function __construct()
	{
		$this->config = new ApplicationConfiguration();
	}

	public function run(): void
	{
		global $argv;

		$mode = $argv[1] ?? '';

		switch ($mode) {
			case 'server:start':
				$server = new Server($this->config);
				$server->start();
				break;
			case 'server:stop':
				$server = new Server($this->config);
				$server->stop();
				break;
			case 'client:start':
				$client = new Client($this->config);
				$client->start();
				break;
			default:
				echo "Unknown mode. Use 'server' or 'client'.\n";
				break;
		}
	}
}