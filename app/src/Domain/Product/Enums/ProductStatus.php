<?php

namespace AnatolyShilyaev\App\Domain\Product\Enums;

enum ProductStatus: string
{
    case CREATED = 'created';
    case COOKING = 'cooking';
    case READY = 'ready';
    case DISCARDED = 'discarded';
}
