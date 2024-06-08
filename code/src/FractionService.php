<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm2;

class FractionService
{
    /**
     * @throws \Exception
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if (0 === $denominator) {
            throw new \Exception('Division by zero');
        }

        if (0 === $numerator) {
            return '0';
        }

        $result = '';

        if ($numerator < 0 xor $denominator < 0) {
            $result .= '-';
        }

        $numeratorAbs = abs($numerator);
        $denominatorAbs = abs($denominator);

        $result .= intdiv($numeratorAbs, $denominatorAbs);
        $remainder = $numeratorAbs % $denominatorAbs;

        if (0.0 === (float) $remainder) {
            return $result;
        }

        $result .= '.';
        $map = [];

        while (0 !== $remainder) {
            $map[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= intdiv($remainder, $denominatorAbs);
            $remainder = $remainder % $denominatorAbs;

            if (array_key_exists($remainder, $map)) {
                $result = substr_replace($result, '(', $map[$remainder], 0);
                $result .= ')';
                break;
            }
        }

        return $result;
    }
}
