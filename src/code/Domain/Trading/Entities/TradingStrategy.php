<?php

declare(strict_types=1);

namespace Domain\Trading\Entities;

use Domain\Trading\ValueObjects\MarketData;
use Domain\Trading\ValueObjects\TradeDecision;
use Domain\Trading\ValueObjects\StrategySettings;

class TradingStrategy
{
    private int $id;
    private string $name;
    private StrategySettings $settings;

    public function __construct(int $id, string $name, StrategySettings $settings)
    {
        $this->id = $id;
        $this->name = $name;
        $this->settings = $settings;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSettings(): StrategySettings
    {
        return $this->settings;
    }

    public function setSettings(StrategySettings $settings): void
    {
        $this->settings = $settings;
    }

    public function analyze(MarketData $marketData): TradeDecision
    {
        // Логика анализа рыночных данных и принятия решения о сделке
        // Возвращает объект TradeDecision
    }

    public function equals(TradingStrategy $other): bool
    {
        return $this->id === $other->id &&
            $this->name === $other->name &&
            $this->settings->equals($other->settings);
    }
}
