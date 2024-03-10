<?php

namespace Otus;

class ApplicationConfiguration
{
	private array $config;

	public function __construct()
	{
		$this->load();
	}

	private function load(): void
	{
		$configuration = parse_ini_file(getenv('CONFIG_APP_PATH'));
		$this->config = is_array($configuration) ? $configuration : [];
	}

	public function getAll(): array
	{
		return $this->config;
	}

	public function getByCode(string $code): ?string
	{
		return $this->config[$code] ?? null;
	}
}