<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum AllowedGenreEnum: string
{
    case Classical = 'classical';
    case Rock = 'rock';
    case Pop = 'pop';
    case Electronic = 'electronic';
    case Jazz = 'jazz';
    case Hip_hop = 'hip_hop';
    case Country = 'country';
    case Folk = 'folk';
    case Blues = 'blues';
    case Indie = 'indie';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
