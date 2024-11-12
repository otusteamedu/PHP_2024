<?php

declare(strict_types=1);

namespace Domain\Trading\Services;

use Domain\Trading\ValueObjects\MarketData;
use Domain\Trading\ValueObjects\StrategySettings;
use Domain\Trading\ValueObjects\TradeDecision;

/**
 * Определяет контракт для всех торговых стратегий
 */
interface TradingStrategyInterface
{
    public function analyze(MarketData $marketData): TradeDecision;
    public function setSettings(StrategySettings $settings): void;
    public function getSettings(): StrategySettings;
}
