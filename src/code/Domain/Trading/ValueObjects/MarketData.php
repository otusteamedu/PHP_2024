<?php

declare(strict_types=1);

namespace Domain\Trading\ValueObjects;

use Domain\Common\ValueObjects\Price;

/**
 * Рыночные данные — это данные, которые используются торговой стратегией для анализа рынка.
 */
class MarketData
{
    private array $data;

    public function __construct(array $data)
    {
        // Пример проверки и преобразования данных
        foreach ($data as $key => $value) {
            if (is_numeric($value)) {
                $data[$key] = new Price((string)$value);
            }
        }
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function equals(MarketData $other): bool
    {
        return $this->data === $other->data;
    }
}
