<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

class ProductWatcher
{
    private array $items = [];
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
        self::getInstance()->items[$product->getId()] = $product;
    }

    public static function get(int $id): ?Product
    {
        return self::getInstance()->items[$id] ?? null;
    }

    public static function remove(int $id): void
    {
        if (isset(self::getInstance()->items[$id])) {
            unset(self::getInstance()->items[$id]);
        }
    }
}
