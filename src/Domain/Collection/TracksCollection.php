<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\Collection\Iterator\ArrayIterator;
use App\Domain\Entity\Track;
use InvalidArgumentException;
use Traversable;

class TracksCollection implements ArrayCollectionInterface
{
    public function __construct(
        private array $elements = []
    ) {
    }

    public function add(mixed $element): void
    {
        $this->assertType($element);


        $this->elements[] = $element;
    }

    public function remove(mixed $element): void
    {
        $this->assertType($element);

        $key = array_search($element, $this->elements, true);
        if ($key !== false) {
            unset($this->elements[$key]);
            $this->elements = array_values($this->elements);
        }
    }

    public function contains(mixed $element): bool
    {
        return in_array($element, $this->elements, true);
    }

    public function size(): int
    {
        return count($this->elements);
    }

    public function clear(): void
    {
        $this->elements = [];
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    private function assertType(mixed $element): void
    {
        if (!($element instanceof Track)) {
            throw new InvalidArgumentException(
                'Неверный тип элемента коллекции. Требуется объект '
                . Track::class
            );
        }
    }
}
