<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw5;

class BracesService
{
    private function validateInput(?string $strOfBraces): string
    {
        if ($strOfBraces === null) {
            return 'Требуется строка в post-параметре string.';
        }

        $strOfBraces = trim($strOfBraces);
        if ('' === $strOfBraces) {
            return 'Передана пустая строка.';
        }

        return '';
    }


    /**
     * @return string пустая строка, скобки расставлены верно. Иначе, что именно не в порядке.
     */
    public function calculateBraces(?string $strOfBraces): string
    {
        $validateMsg = $this->validateInput($strOfBraces);
        if (!empty($validateMsg)) {
            return $validateMsg;
        }

        $countOpenedBraces = 0;
        $len = strlen($strOfBraces);
        for ($index = 0; $index < $len; $index++) {
            $char = $strOfBraces[$index];
            if ($char === '(') {
                $countOpenedBraces++;
            } elseif ($char === ')') {
                $countOpenedBraces--;
                if ($countOpenedBraces < 0) {
                    break;
                }
            } else {
                return 'В строке посторонние символы.';
            }
        }

        return (0 === $countOpenedBraces) ? '' : 'Ошибка в расстановке скобок.';
    }
}
