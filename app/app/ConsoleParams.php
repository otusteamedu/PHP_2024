<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

final readonly class ConsoleParams
{
    private ?string $command;
    private array $options;
    private array $arguments;

    public function __construct(array $argv)
    {
        $this->command = $argv[1] ?? null;
        $this->options = $this->parseOptions($argv);
        $this->arguments = $this->parseArguments($argv);
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    private function parseOptions(array $argv): array
    {
        $res = [];

        for ($i = 2; $i < count($argv); $i++) {
            if (str_starts_with($argv[$i], '--')) {
                $option = explode('=', substr($argv[$i], 2));
                $res[$option[0]] = $option[1];
            }
        }

        return $res;
    }

    private function parseArguments(array $argv): array
    {
        $res = [];

        for ($i = 2; $i < count($argv); $i++) {
            if (str_starts_with($argv[$i], '--')) {
                continue;
            }
            $res[] = $argv[$i];
        }

        return $res;
    }
}
