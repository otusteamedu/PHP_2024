<?php

namespace app\Services;

class ValidationService
{
    public function validateString(string $string): array
    {
        if (empty($string)) {
            return ['success' => false, 'message' => 'Ошибка: строка пуста.'];
        }

        $balance = 0;
        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $char = $string[$i];
            if ($char == '(') {
                $balance++;
            } elseif ($char == ')') {
                $balance--;
            }

            if ($balance < 0) {
                return ['success' => false, 'message' => 'Ошибка: количество открытых и закрытых скобок не совпадает.'];
            }
        }

        if ($balance == 0) {
            return ['success' => true, 'message' => 'Строка корректна: количество открытых и закрытых скобок совпадает.'];
        } else {
            return ['success' => false, 'message' => 'Ошибка: количество открытых и закрытых скобок не совпадает.'];
        }
    }
}