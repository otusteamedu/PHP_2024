<?php

declare(strict_types=1);

namespace App;

class App
{
    private function validateString(string $str): bool
    {
        $balance = 0;

        for ($i = 0, $len = strlen($str); $i < $len; $i++) {
            if ($str[$i] === '(') {
                $balance++;
            } elseif ($str[$i] === ')') {
                $balance--;
            }

            // Если на каком-то этапе баланс < 0, значит, скобки некорректны
            if ($balance < 0) {
                return false;
            }
        }

        // Строка корректна, если баланс в конце = 0
        return $balance === 0;
    }

    private function isNotEmpty(string $str): bool
    {
        return $str != '';
    }

    private function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function run(): void
    {
        $isPost = $this->isPost();
        if ($isPost) {
            $string = $_POST['string'] ?? null;
            $isNotEmpty = $this->isNotEmpty($string);
            if ($isNotEmpty) {
                $isValid = $this->validateString($string);
                if ($isValid) {
                    http_response_code(HttpStatus::OK); // Всё хорошо
                    echo "Все хорошо: строка корректна.";
                    return;
                }

                http_response_code(HttpStatus::BAD_REQUEST); // Некорректный запрос
                echo "Ошибка: некорректный формат строки";
                return;
            }

            http_response_code(HttpStatus::BAD_REQUEST); // Некорректный запрос
            echo "Ошибка: строка пуста";
            return;
        }

        http_response_code(HttpStatus::BAD_REQUEST);
        echo "Method Not Allowed";
    }
}
