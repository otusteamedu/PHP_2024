<?php

declare(strict_types=1);

namespace IraYu\Hw12\Domain\Entity;

class EventProperties extends \SplQueue
{
    public function addProperty(EventProperty $property): static
    {
        $this[] = $property;

        return $this;
    }

    public function getByName(string $name): ?EventProperty
    {
        foreach ($this as $property) {
            if ($property->getName() === $name) {
                return $property;
            }
        }

        return null;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this as $property) {
            $result[$property->getName()] = $property->getValue();
        }

        return $result;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getNames(): array
    {
        $result = [];
        foreach ($this as $property) {
            $result[] = $property->getName();
        }

        return $result;
    }
}
