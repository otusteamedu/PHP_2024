<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Providers;

use Kiryao\Sockchat\Helpers\DTO\Exception\ConstructorNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotImplementException;
use Kiryao\Sockchat\Helpers\DTO\Exception\ClassNotFoundException;
use Kiryao\Sockchat\Helpers\DTO\DTOBuilder;
use Kiryao\Sockchat\Config\Providers\Abstract\AbstractConfigProvider;
use Kiryao\Sockchat\Config\DTO\Chat\Config;

class ChatConfigProvider extends AbstractConfigProvider
{
    /**
     * @return Config
     * @throws ClassNotFoundException
     * @throws ClassNotImplementException
     * @throws ConstructorNotFoundException
     * @throws \ReflectionException
     */
    protected function buildConfig(): Config
    {
        return DTOBuilder::createFromArray($this->config, Config::class);
    }
}
