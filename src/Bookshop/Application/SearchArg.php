<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application;

enum SearchArg: string
{
    case Title = 'title';
    case Category = 'category';
    case PriceFrom = 'priceFrom';
    case PriceTo = 'priceTo';
    case Shop = 'shop';
    case Stock = 'stock';
    case Page = 'page';
    case PageSize = 'pageSize';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
