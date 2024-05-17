<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\StatusProduct;

enum StatusProduct: string
{
    case Preparing = "подготавливается";
    case Cooking = "готовится";
    case Ready = "готово";

    public static function getStatus(): array
    {
        return [self::Preparing, self::Cooking, self::Ready];
    }
}
