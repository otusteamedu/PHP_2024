<?php

declare(strict_types=1);

namespace Domain\Trading\ValueObjects;

use Domain\Common\ValueObjects\Price;

/**
 * Решение о сделке — это результат анализа рыночных данных торговой стратегией.
 */
class TradeDecision
{
    private TradeType $type;
    private Asset $asset;
    private int $quantity;
    private Price $price;

    public function __construct(TradeType $type, Asset $asset, int $quantity, Price $price)
    {
        $this->type = $type;
        $this->asset = $asset;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getType(): TradeType
    {
        return $this->type;
    }

    public function getAsset(): Asset
    {
        return $this->asset;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function equals(TradeDecision $other): bool
    {
        return $this->type->equals($other->type) &&
            $this->asset->equals($other->asset) &&
            $this->quantity === $other->quantity &&
            $this->price->equals($other->price);
    }
}
