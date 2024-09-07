<?php

declare(strict_types=1);

namespace IraYu\Hw11\Service;

use IraYu\Hw11\Filter;

class FilterService
{
    public function __construct(
        protected array $rawFilter,
    ) {
    }

    public function getQuery($fieldName): ?array
    {
        reset($this->rawFilter);
        $query = [];
        while ($raw = current($this->rawFilter)) {
            if (str_starts_with($raw, '--query')) {
                $value = trim(substr($raw, 8));
                if (!empty($value)) {
                    $query[] = $value;
                }
            }
            next($this->rawFilter);
        }
        reset($this->rawFilter);

        return empty($query) ? null : (new Filter\MatchFilter($fieldName, implode(' ', $query)))->getFilter();
    }

    public function getFilter(): array
    {
        reset($this->rawFilter);
        $filters = [];
        while ($raw = current($this->rawFilter)) {
            [$fieldName, $fieldValue] = explode('=', $raw);
            $fieldName = strtolower($fieldName);
            if (str_starts_with($fieldName, '--min') || str_starts_with($fieldName, '--max')) {
                $fieldName = substr($fieldName, 5);
                $filter = $filters['range' . $fieldName] ?? new Filter\Range($fieldName);
                $filters['range' . $fieldName] = $filter;
                str_starts_with($raw, '--max') ? $filter->setMin($fieldValue)
                    : $filter->setMax($fieldValue)
                ;
            } elseif (str_starts_with($fieldName, '--eq')) {
                $fieldName = substr($fieldName, 4);
                $filters['eq' . $fieldName] = new Filter\Equality($fieldName, $fieldValue);
            }
            next($this->rawFilter);
        }
        reset($this->rawFilter);

        return array_map(fn($filter) => $filter->getFilter(), array_values($filters));
    }
}
