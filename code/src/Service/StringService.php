<?php

namespace KRudenko\Otus\Service;

class StringService
{
    public function processString(): string
    {
        $string = $_POST['string'] ?? null;

        if (empty($string)) {
            http_response_code(400);
            return "Отправлена пустая строка.";
        }

        $ans = $this->calculateBrackets($string);

        if ($ans === 0) {
            http_response_code(200);
            return "Строка корректна";
        } else {
            http_response_code(400);
            return "Строка не корректна";
        }
    }

    public function calculateBrackets(string $string): int
    {
        $ans = 0;
        foreach (str_split($string) as $char) {
            if ($char === '(') {
                $ans++;
            } else {
                $ans--;
            }
            if ($ans === -1) {
                break;
            }
        }
        return $ans;
    }
}
