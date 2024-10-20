<?php

class Validation
{
    public function validateString($string)
    {
        // Проверка на непустоту
        if (empty($string)) {
            return "String cannot be empty.";
        }

        // Проверка на корректность количества открытых и закрытых скобок
        $openCount = substr_count($string, '(');
        $closeCount = substr_count($string, ')');

        if ($openCount !== $closeCount) {
            return "Mismatched parentheses.";
        }

        // Все проверки пройдены
        return true;
    }
}
