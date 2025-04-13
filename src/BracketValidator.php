<?php

declare(strict_types=1);

/**
 * BracketValidator class to check if brackets are balanced.
 */
class BracketValidator
{
    /**
     * Check if the brackets in the string are balanced.
     *
     * @param string $str
     * @return bool
     */
    public function isBalanced(string $str): bool
    {
        // Initialize counter
        $count = 0;

        // Process each character
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] === '(') {
                $count++;
            } elseif ($str[$i] === ')') {
                $count--;
            }

            // If count is negative, closing brackets come first
            if ($count < 0) {
                return false;
            }
        }

        // Count must be zero for balanced brackets
        return $count === 0;
    }
}
