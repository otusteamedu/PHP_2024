<?php

declare(strict_types=1);

namespace Domain\Trading\Entities;

use Domain\Common\ValueObjects\Price;
use Domain\Trading\ValueObjects\Asset;
use Domain\Trading\ValueObjects\TradeType;

/**
 * Сделка представляет собой результат принятия решения торговой стратегией о покупке или продаже актива.
 * Сделка содержит информацию о типе операции (покупка/продажа), активе, количестве и цене.
 */
class Trade
{
    private int $id;
    private TradeType $type;
    private Asset $asset;
    private int $quantity;
    private Price $price;

    public function __construct(int $id, TradeType $type, Asset $asset, int $quantity, Price $price)
    {
        $this->id = $id;
        $this->type = $type;
        $this->asset = $asset;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function equals(Trade $other): bool
    {
        return $this->id === $other->id &&
            $this->type->equals($other->type) &&
            $this->asset->equals($other->asset) &&
            $this->quantity === $other->quantity &&
            $this->price->equals($other->price);
    }
}
