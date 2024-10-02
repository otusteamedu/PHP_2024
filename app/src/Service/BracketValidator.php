<?php

declare(strict_types=1);

namespace App\Service;

class BracketValidator
{
    /**
     * @param string $string
     * @return bool
     */
    public function validate(string $string): bool
    {
        if (!empty($string)) {
            $bracketArray = str_split($string);
        } else {
            return false;
        }

        if ($bracketArray[0] === ')' || count($bracketArray) === 0) {
            http_response_code(400);
            return false;
        }

        $stack = [];

        foreach ($bracketArray as $bracket) {
            if ($bracket === '(') {
                $stack[] = $bracket;
            } else {
                if (array_pop($stack) !== '(') return false;
            }
        }

        if (count($stack) !== 0) {
            return false;
        }

        return true;
    }
}
