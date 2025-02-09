<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5;

use Exception;

enum ApplicationTypes: string
{
    case Client = 'client';
    case Server = 'server';

    public static function tryFromOrFail(string $value): self
    {
        if (!$enum = self::tryFrom($value)) {
            throw new Exception("Недопустимы тип приложения \"$value\"");
        }

        return $enum;
    }
}
