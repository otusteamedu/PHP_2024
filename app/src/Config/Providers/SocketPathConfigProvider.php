<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Providers;

use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigNotFoundException;
use Kiryao\Sockchat\Config\Exception\ConfigSectionNotFoundException;
use Kiryao\Sockchat\Config\Providers\Abstract\AbstractConfigProvider;
use Kiryao\Sockchat\Helpers\DTO\DTOBuilder;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotImplementException;
use Kiryao\Sockchat\Config\DTO\SocketPath\Config;
use Kiryao\Sockchat\Helpers\DTO\Exception\ConstructorNotFoundException;

class SocketPathConfigProvider extends AbstractConfigProvider
{
    /**
     * @throws ConfigSectionNotFoundException
     * @throws ConfigKeyIsEmptyException
     * @throws ConfigKeyNotFoundException
     * @throws ConfigNotFoundException
     * @throws ClassNotFoundException
     * @throws ClassNotImplementException
     * @throws \ReflectionException
     * @throws ConstructorNotFoundException
     */
    public function load(): Config
    {
        $this->parse();

        return DTOBuilder::createFromArray($this->config, Config::class);
    }
}
