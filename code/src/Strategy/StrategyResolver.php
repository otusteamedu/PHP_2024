<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Strategy;

class StrategyResolver
{
    const STRATEGY_LIST = [
        'txt' => PrintTxt::class,
        'html' => PrintHtml::class,
    ];
    public function getStrategy(string $extension): Strategy
    {
        if (!array_key_exists($extension, self::STRATEGY_LIST)) {
            throw new \InvalidArgumentException("Strategy \"{$extension}\" is not supported");
        }
        $strategyClass = self::STRATEGY_LIST[$extension];
        return new $strategyClass();
    }
}