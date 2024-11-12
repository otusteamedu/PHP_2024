<?php

declare(strict_types=1);

namespace Domain\Trading\ValueObjects;

class TradeType
{
    public const BUY = 'buy';
    public const SELL = 'sell';

    private string $type;

    private function __construct(string $type)
    {
        if (!in_array($type, [self::BUY, self::SELL])) {
            throw new \InvalidArgumentException('Invalid trade type');
        }
        $this->type = $type;
    }

    public static function buy(): self
    {
        return new self(self::BUY);
    }

    public static function sell(): self
    {
        return new self(self::SELL);
    }

    public function getName(): string
    {
        return $this->type;
    }

    public function equals(TradeType $other): bool
    {
        return $this->type === $other->type;
    }
}
