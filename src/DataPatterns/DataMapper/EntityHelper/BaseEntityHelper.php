<?php
declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper\EntityHelper;

use PDO;

abstract class BaseEntityHelper
{
    public function __construct(protected PDO $pdo)
    {
    }
}
