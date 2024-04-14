<?php

declare(strict_types=1);

namespace Hukimato\App\Components;

use PDO;

class PdoFactory
{
    public static function createPgPDO(): PDO
    {
        return new PDO(sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            'postgresql',
            '5432',
            'hukimato',
            'hukimato',
            'hukimato',
        ));
    }
}
