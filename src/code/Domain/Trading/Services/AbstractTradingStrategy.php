<?php

declare(strict_types=1);

namespace Domain\Trading\Services;

use Domain\Trading\ValueObjects\MarketData;
use Domain\Trading\ValueObjects\StrategySettings;
use Domain\Trading\ValueObjects\TradeDecision;

/**
 * Реализует общие методы для всех торговых стратегий
 */
class AbstractTradingStrategy implements TradingStrategyInterface
{

    public function analyze(MarketData $marketData): TradeDecision
    {
        // TODO: Implement analyze() method.
    }

    public function setSettings(StrategySettings $settings): void
    {
        // TODO: Implement setSettings() method.
    }

    public function getSettings(): StrategySettings
    {
        // TODO: Implement getSettings() method.
    }
}
