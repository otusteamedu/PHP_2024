<?php

declare(strict_types=1);

namespace Otus\Hw14;

class Phone
{
    /**
     * @param string|null $digits
     * @return array
     */
    public function letterCombinations(?string $digits): array
    {
        if (!$this->validateData($digits)) return [];

        return $this->generateCombinations($digits, '', []);
    }

    /**
     * @param string|null $digits
     * @return bool
     */
    private function validateData(?string $digits): bool
    {
        return !empty($digits) && strlen($digits) <= 4;
    }

    /**
     * @param string|null $digits
     * @param string $current
     * @param array $result
     * @return array
     */
    private function generateCombinations(?string $digits, string $current, array $result): array
    {
        // Если строка цифр пуста, добавить текущую комбинацию в результат
        if (empty($digits)) {
            $result[] = $current;
            return $result;
        }

        // Получаем первую цифру из строки
        $digit = $digits[0];
        // Получаем буквы, соответствующие этой цифре
        $letters = PhoneDictionary::$numbersToLetters[$digit] ?? null;

        // Для каждой буквы генерируем новую комбинацию, вызывая функцию рекурсивно
        foreach ($letters as $letter) {
            $result = $this->generateCombinations(substr($digits, 1), $current . $letter, $result);
        }

        return $result;
    }
}
