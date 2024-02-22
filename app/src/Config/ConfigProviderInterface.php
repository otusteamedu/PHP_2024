<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config;

interface ConfigProviderInterface
{
    public function load(string $configHeader): array;
}
