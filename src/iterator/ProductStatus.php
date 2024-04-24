<?php

declare(strict_types=1);

namespace Afilipov\Hw16\iterator;

enum ProductStatus: string
{
    case Preparing = 'preparing';
    case Cooking = 'cooking';
    case Ready = 'ready';

    public static function getStatuses(): array
    {
        return [self::Preparing, self::Cooking, self::Ready];
    }
}
