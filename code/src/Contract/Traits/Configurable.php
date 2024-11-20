<?php

namespace IraYu\Contract\Traits;

trait Configurable
{
    protected array $configs = [];

    public function setConfigs(array $configs): static
    {
        $this->configs = $configs;

        return $this;
    }

    public function getConfigs(): array
    {
        return $this->configs;
    }

    public function getConfig(string $name): mixed
    {
        return $this->configs[$name] ?? null;
    }
}
