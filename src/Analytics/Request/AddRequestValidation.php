<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Request;

use AlexanderGladkov\Analytics\Application\Arg\AddArg;

use LogicException;

class AddRequestValidation
{
    public function validateArgs(array $args): array
    {
        $possibleArgNames = AddArg::values();
        foreach ($args as $argName => $value) {
            if (!in_array($argName, $possibleArgNames)) {
                throw new LogicException();
            }
        }

        $required = [
            AddArg::Priority,
            AddArg::Value,
        ];
        $integerGreaterZero = [
            AddArg::Priority,
        ];

        foreach ($required as $arg) {
            $argName = $arg->value;
            if (!array_key_exists($argName, $args)) {
                throw new RequestValidationException("$argName должен быть указан!");
            }
        }

        foreach ($integerGreaterZero as $arg) {
            $argName = $arg->value;
            if (!array_key_exists($argName, $args)) {
                continue;
            }

            $args[$argName] = $this->validateIntegerGreaterZero($argName, $args[$argName]);
        }

        $conditionArgName = AddArg::Condition->value;
        $args[$conditionArgName] = (new RequestValidationHelper())->validateConditionArg($args[$conditionArgName]);
        return $args;
    }


    private function validateIntegerGreaterZero(string $name, string $value): int
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);
        if ($value === false) {
            throw new RequestValidationException("$name должно быть целым числом!");
        }

        if ($value <= 0) {
            throw new RequestValidationException("$name должно быть положительным целым числом!");
        }

        return $value;
    }
}