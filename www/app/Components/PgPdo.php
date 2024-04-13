<?php

declare(strict_types=1);

namespace Hukimato\App\Components;

use PDO;

class PgPdo
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new PDO(sprintf(
                "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                'postgresql',
                '5432',
                'hukimato',
                'hukimato',
                'hukimato',
            ));
        }

        return self::$instance;
    }
}
