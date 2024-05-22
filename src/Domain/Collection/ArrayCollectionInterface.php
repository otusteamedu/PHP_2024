<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use IteratorAggregate;

interface ArrayCollectionInterface extends IteratorAggregate
{
    public function add(mixed $element): void;
    public function remove(mixed $element): void;
    public function contains(mixed $element): bool;
    public function size(): int;

    public function clear(): void;

    public function toArray(): array;
}
