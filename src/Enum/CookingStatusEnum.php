<?php

declare(strict_types=1);

namespace App\Enum;

enum CookingStatusEnum: string
{
    case WAITING = 'Ожидание';
    case PREPARING = 'Подготовка';
    case COOKING = 'Готовится';
    case COOKED = 'Приготовлено';
}
