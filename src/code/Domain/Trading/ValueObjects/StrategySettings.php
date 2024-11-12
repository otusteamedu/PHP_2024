<?php

declare(strict_types=1);

namespace Domain\Trading\ValueObjects;

use Domain\Common\ValueObjects\Money;

/**
 * Настройки стратегии — это параметры, которые пользователь может настраивать в админке для каждой торговой стратегии.
 */
class StrategySettings
{
    private array $settings;

    public function __construct(array $settings)
    {
        // Пример проверки и преобразования данных
        foreach ($settings as $key => $value) {
            if (is_numeric($value)) {
                $settings[$key] = new Money((string)$value);
            }
        }
        $this->settings = $settings;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function equals(StrategySettings $other): bool
    {
        return $this->settings === $other->settings;
    }
}
