<?php

declare(strict_types=1);

namespace app\base\entity;

enum Status: string
{
    case Active = 'Active';
    case Success = 'Success';

    public function isActive(): bool
    {
        return $this === self::Active;
    }

}
