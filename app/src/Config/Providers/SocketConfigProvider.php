<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Providers;

use Kiryao\Sockchat\Helpers\DTO\Exception\ConstructorNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotImplementException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\DTOBuilder;
use Kiryao\Sockchat\Config\Providers\Abstract\AbstractConfigProvider;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Config\DTO\Socket\Config;

class SocketConfigProvider extends AbstractConfigProvider
{
    /**
     * @return Config
     * @throws ClassNotFoundException
     * @throws ClassNotImplementException
     * @throws ConstructorNotFoundException
     * @throws SocketConstantNotFoundException
     * @throws \ReflectionException
     */
    protected function buildConfig(): Config
    {
        foreach ($this->config as $key => $value) {
            $this->checkSocketConstant($key, $value);
        }
        return DTOBuilder::createFromArray($this->config, Config::class);
    }

    /**
     * @throws SocketConstantNotFoundException
     */
    private function checkSocketConstant(string $key, int|string $value): void
    {
        if (!is_int($value) && !defined($value)) {
            throw new SocketConstantNotFoundException($key, $value);
        }
    }
}
