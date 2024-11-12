<?php

declare(strict_types=1);

namespace Domain\Trading\Strategies;

use Domain\Trading\ValueObjects\MarketData;
use Domain\Trading\ValueObjects\TradeDecision;
use Domain\Trading\ValueObjects\TradeType;
use Domain\Trading\ValueObjects\Asset;
use Domain\Common\ValueObjects\Money;
use Domain\Trading\Services\AbstractTradingStrategy;

class SimpleMovingAverageStrategy extends AbstractTradingStrategy
{
    public function analyze(MarketData $marketData): TradeDecision
    {
        $prices = array_map(fn($price) => $price->getValue(), $marketData->getData());
        $averagePrice = array_sum($prices) / count($prices);

        $currentPrice = end($prices);

        $tradeType = $currentPrice > $averagePrice ? TradeType::buy() : TradeType::sell();

        return new TradeDecision(
            $tradeType,
            new Asset('AAPL', 'Apple Inc.', new Money((string)$currentPrice)),
            1,
            new Money((string)$currentPrice)
        );
    }
}
