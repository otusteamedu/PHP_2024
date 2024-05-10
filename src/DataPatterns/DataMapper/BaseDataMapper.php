<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper;

use PDO;

abstract class BaseDataMapper
{
    public function __construct(protected PDO $pdo)
    {
    }
}
