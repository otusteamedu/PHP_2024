<?php

declare(strict_types=1);

namespace Domain\Trading\ValueObjects;

use Domain\Common\ValueObjects\Price;

/**
 * Актив — это финансовый инструмент,
 * который может быть куплен или продан на бирже (например, акция, облигация, криптовалюта).
 */
class Asset
{
    private string $symbol;
    private string $name;
    private Price $price;

    public function __construct(string $symbol, string $name, Price $price)
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function equals(Asset $other): bool
    {
        return $this->symbol === $other->symbol &&
            $this->name === $other->name &&
            $this->price->equals($other->price);
    }
}
