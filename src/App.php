<?php

declare(strict_types=1);

class App
{
    /**
     * @throws Exception
     */
    public static function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $string = $_POST['string'] ?? '';
            if (empty($string)) {
                throw new Exception("Пустая строка. Пожалуйста, предоставьте строку для проверки", 400);
            }
            if (self::validateString($string)) {
                throw new Exception("Все хорошо. Скобки расставлены корректно.", 200);
            } else {
                throw new Exception("Все плохо. Некорректная расстановка скобок.", 400);
            }
        } else {
            throw new Exception("Метод не поддерживается. Используйте POST-запрос.", 405);
        }
    }

    private static function validateString(mixed $string): bool
    {
        $balance = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $balance++;
            } elseif ($string[$i] === ')') {
                $balance--;
            }

            if ($balance < 0) {
                return false;
            }
        }

        return $balance === 0;
    }
}
