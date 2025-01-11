<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

class ProductWatcher
{
    private array $items = [];
    private array $originalItems = [];
    private static self $instance;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function add(Product $product): void
    {
        $original = clone $product;
        self::getInstance()->items[$product->getId()] = $product;
        self::getInstance()->originalItems[$original->getId()] = $original;
    }

    public static function get(int $id): ?Product
    {
        return self::getInstance()->items[$id] ?? null;
    }

    public static function getOriginal(int $id): ?Product
    {
        return self::getInstance()->originalItems[$id] ?? null;
    }

    public static function remove(int $id): void
    {
        if (isset(self::getInstance()->items[$id])) {
            unset(self::getInstance()->items[$id]);
        }

        if (isset(self::getInstance()->originalItems[$id])) {
            unset(self::getInstance()->originalItems[$id]);
        }
    }
}
