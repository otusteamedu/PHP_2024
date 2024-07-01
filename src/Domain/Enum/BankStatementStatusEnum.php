<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Enum;

enum BankStatementStatusEnum: string
{
    case Preparing = 'preparing';
    case Ready = 'ready';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
