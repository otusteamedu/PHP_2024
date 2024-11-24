<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

class Checker
{
    public function check($string)
    {
        if (empty($string)) {
            return false;
        }

        $openBr = 0;
        $closeBr = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $openBr++;
            } else {
                $closeBr++;
            }

            if ($closeBr > $openBr) {
                return false;
            }
        }
        return $openBr === $closeBr;
    }
}
