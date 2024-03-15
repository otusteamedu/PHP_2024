<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class Config
{
    private string $config_path;

    function __construct(string $config_path) {
        $this->config_path = $config_path;
    }
}
