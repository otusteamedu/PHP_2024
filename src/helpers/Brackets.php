<?php

namespace helpers;

class Brackets
{
    private const OPEN = '(';
    private const CLOSE = ')';

    /**
     * @param $string
     * @return bool
     */
    function validate($string): bool
    {
        if(empty($string)) {
            return false;
        }

        if (!$this->validateCountBrackets($string)) {
            return false;
        }

        return $this->validateCorrectOpenClose($string);
    }

    /**
     * @param $string
     * @return bool
     */
    private function validateCorrectOpenClose($string): bool
    {
        $length = mb_strlen($string);
        $sequence = [];
        for ($i = 0; $i < $length; $i++) {
            $letter = $string[$i];

            if ($letter === self::OPEN) {
                $sequence[] = $letter;
            } elseif ($letter === self::CLOSE) {
                $lastSequenceSymbol = array_pop($sequence);

                if (self::OPEN != $lastSequenceSymbol) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $string
     * @return bool
     */
    private function validateCountBrackets($string): bool
    {
        $countOpen = substr_count($string, self::OPEN);
        $countClose = substr_count($string, self::CLOSE);

        return !($countOpen != $countClose);
    }
}
