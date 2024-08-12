<?php

declare(strict_types=1);

namespace App\Provider;

use PDO;

interface DatabaseProviderInterface
{
    public function getConnection(): PDO;
}
