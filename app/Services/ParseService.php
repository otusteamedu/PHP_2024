<?php

declare(strict_types=1);

namespace App\Services;

readonly class ParseService
{
    protected array $env;


    public function __construct(private string $envPath)
    {
        $this->env = $this->parse($this->envPath);
    }

    private function parse(string $envPath): array
    {
        return parse_ini_file($envPath);
    }

}

