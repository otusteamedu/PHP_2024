<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config;

use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;

/**
 * @throws ConfigNotFoundException
 * @throws ConfigKeyNotFoundException
 */
class SocketConfig
{
    public function __construct(private array $config)
    {
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getPath(): string
    {
        return (string) $this->getValue('path');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getMaxLength(): int
    {
        return (int) $this->getValue('max_length');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getDomain(): int
    {
        return (int) $this->getValue('domain');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getType(): int
    {
        return (int) $this->getValue('type');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getProtocol(): int
    {
        return (int) $this->getValue('protocol');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getBacklog(): int
    {
        return (int) $this->getValue('backlog');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getFlags(): int
    {
        return (int) $this->getValue('flags');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function getPort(): int
    {
        return (int) $this->getValue('port');
    }

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    private function getValue($key): string|int
    {
        if (!array_key_exists($key, $this->config)) {
            throw new ConfigKeyNotFoundException("Config key '$key' not found.");
        }

        $value = $this->config[$key];

        if ($value === '' | $value === null) {
            throw new ConfigKeyIsEmptyException("Config key '$key' is empty.");
        }

        if ($key !== 'path') {
            $value = $this->checkSocketConstant($value);
        }

        return $value;
    }

    /**
     * @throws SocketConstantNotFoundException
     */
    private function checkSocketConstant(string|int $value): string|int
    {
        if (!is_int($value)) {
            if (!defined($value)) {
                throw new SocketConstantNotFoundException("Socket constant '$value' not found.");
            }
            $value = constant($value);
        }
        return $value;
    }
}
