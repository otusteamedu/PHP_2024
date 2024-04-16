<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Index;

use AlexanderGladkov\Bookshop\Application\SearchArg;
use LogicException;

class SearchParamsValidation
{
    public function validateArgs(array $args): array
    {
        $possibleArgNames = SearchArg::values();
        foreach ($args as $argName => $value) {
            if (!in_array($argName, $possibleArgNames)) {
                throw new LogicException();
            }
        }

        $required = [
            SearchArg::Page,
            SearchArg::PageSize,
        ];
        $integerEqualsOrGreaterZero = [
            SearchArg::PriceFrom,
            SearchArg::PriceTo,
            SearchArg::Stock,
        ];
        $integerGreaterZero = [
            SearchArg::Page,
            SearchArg::PageSize,
        ];

        foreach ($required as $arg) {
            $argName = $arg->value;
            if (!array_key_exists($argName, $args)) {
                throw new SearchParamsValidationException("$argName должен быть указан!");
            }
        }

        foreach ($integerEqualsOrGreaterZero as $arg) {
            $argName = $arg->value;
            if (!array_key_exists($argName, $args)) {
                continue;
            }

            $args[$argName] = $this->validateIntegerEqualsOrGreaterZero($argName, $args[$argName]);
        }

        foreach ($integerGreaterZero as $arg) {
            $argName = $arg->value;
            if (!array_key_exists($argName, $args)) {
                continue;
            }

            $args[$argName] = $this->validateIntegerGreaterZero($argName, $args[$argName]);
        }

        return $args;
    }

    private function validateIntegerEqualsOrGreaterZero(string $name, string $value): int
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        if ($value === false) {
            throw new SearchParamsValidationException("$name должно быть целым числом!");
        }

        if ($value < 0) {
            throw new SearchParamsValidationException("$name должно быть неотрицательным целым числом!");
        }

        return $value;
    }

    private function validateIntegerGreaterZero(string $name, string $value): int
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        if ($value === false) {
            throw new SearchParamsValidationException("$name должно быть целым числом!");
        }

        if ($value <= 0) {
            throw new SearchParamsValidationException("$name должно быть положительным целым числом!");
        }

        return $value;
    }
}
