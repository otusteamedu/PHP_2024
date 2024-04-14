<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Search;

class SearchCriteria
{
    public function __construct(private array $searchData)
    {
    }

    public function match(array $conditions): bool
    {
        if (0 === count($conditions)) {
            return false;
        }

        foreach ($this->searchData as $name => $value) {
            if (!isset($conditions[$name])) {
                continue;
            }

            if ($conditions[$name] !== $value) {
                return false;
            }
        }

        return true;
    }
}
