<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Providers\Abstract;

use Kiryao\Sockchat\Config\Providers\Interface\ConfigProviderInterface;
use Kiryao\Sockchat\Config\Exception\ConfigSectionNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;

abstract class AbstractConfigProvider implements ConfigProviderInterface
{
    protected array $config;

    public function __construct(protected string $configPath, protected string $configSection)
    {
    }

    abstract public function load();

    /**
     * @throws ConfigNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ConfigSectionNotFoundException
     */
    protected function parse(): void
    {
        $this
            ->getConfig()
            ->selectSection()
            ->normalizeConfigValues()
            ->checkConfig();
    }

    /**
     * @throws ConfigNotFoundException
     */
    protected function getConfig(): self
    {
        $config = parse_ini_file($this->configPath, true);

        if ($config === false) {
            throw new ConfigNotFoundException();
        }

        $this->config = $config;

        return $this;
    }

    /**
     * @throws ConfigSectionNotFoundException
     */
    protected function selectSection(): self
    {
        if (!array_key_exists($this->configSection, $this->config)) {
            throw new ConfigSectionNotFoundException($this->configSection);
        }

        $this->config = $this->config[$this->configSection];

        return $this;
    }

    protected function normalizeConfigValues(): self
    {
        foreach ($this->config as $key => $value) {
            $this->config[$key] = is_numeric($value) ? (int) $value : (string) $value;
        }

        return $this;
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     */
    protected function checkConfig(): self
    {
        foreach ($this->config as $key => $value) {
            $this->checkConfigKey($key);
            $this->checkConfigValue($key, $value);
        }

        return $this;
    }

    /**
     * @throws ConfigKeyNotFoundException
     */
    protected function checkConfigKey(string $key): void
    {
        if (!array_key_exists($key, $this->config)) {
            throw new ConfigKeyNotFoundException($key);
        }
    }

    /**
     * @throws ConfigKeyIsEmptyException
     */
    protected function checkConfigValue(string $key, string|int $value): void
    {
        if ($value === '' | $value === null) {
            throw new ConfigKeyIsEmptyException($key);
        }
    }
}
