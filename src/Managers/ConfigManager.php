<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Managers;

use RailMukhametshin\ConfigManager\ConfigManager as BaseConfigManager;

final class ConfigManager extends BaseConfigManager
{
    public function getAll(): array
    {
        return $this->configurations;
    }
}
