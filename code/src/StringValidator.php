<?php
declare(strict_types=1);

namespace Pyivanov\hw4;

use Exception;
use \InvalidArgumentException;

/**
 * @param ?string $str Проверяемая строка
 */
class StringValidator
{
    public function __construct(protected ?string $str)
    {
    }

    /**
     * @throws Exception
     */
    public function validate(): string
    {
        if (!$this->isStringEmpty()) {
            throw new InvalidArgumentException('Проверяемая строка не может быть пустой!');
        }

        if (!$this->isNumOfBracketsCorrect()) {
            throw new InvalidArgumentException(
                'Количество открывающихся и закрывающихся скобок не равно друг другу!'
            );
        }

        return 'Строка корректна';
    }

    /**
     * Проверка строки на непустоту
     * @return bool
     */
    protected function isStringEmpty(): bool
    {
        return isset($this->str) && $this->str !== '';
    }

    /**
     * Проверка строки на корректность кол-ва открытых и закрытых скобок
     * @return bool
     * @throws Exception
     */
    protected function isNumOfBracketsCorrect(): bool
    {
        $counterBrackets = 0;
        $strLength = strlen($this->str);

        if ($this->str[0] === ')') {
            throw new InvalidArgumentException("Строка не может начинаться с ')'!", 400);
        }

        if ($this->str[$strLength - 1] === '(') {
            throw new InvalidArgumentException("Строка не может заканчиваться ')'!", 400);
        }


        for ($i = 0; $i < $strLength; $i++) {
            switch ($this->str[$i]) {
                case '(':
                    $counterBrackets++;
                    break;
                case ')':
                    $counterBrackets--;
                    break;
                default:
                    break;
            }
        }

        if ($counterBrackets < 0 || $counterBrackets > 0) {
            throw new InvalidArgumentException("В строке '$this->str' не все скобки имеют пару.", 400);
        }

        return true;
    }
}