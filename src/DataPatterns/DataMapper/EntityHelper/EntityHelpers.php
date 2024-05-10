<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\DataMapper\EntityHelper;

use PDO;

class EntityHelpers
{
    private static ?self $instance = null;
    private array $helpers = [];

    private function __construct()
    {
    }

    public static function getMovieHelper(PDO $pdo): MovieEntityHelper
    {
        return self::getInstance()->getHelper($pdo, MovieEntityHelper::class);
    }

    public static function getGenreHelper(PDO $pdo): GenreEntityHelper
    {
        return self::getInstance()->getHelper($pdo, GenreEntityHelper::class);
    }

    private static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getHelper(PDO $pdo, string $className): mixed
    {
        $key = $this->getKey($pdo, $className);
        if (!array_key_exists($key, $this->helpers)) {
            $this->helpers[$key] = new $className($pdo);
        }

        return $this->helpers[$key];
    }

    private function getKey(PDO $pdo, string $className): string
    {
        return spl_object_hash($pdo) . '-' . $className;
    }
}
