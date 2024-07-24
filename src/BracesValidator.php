<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw4;

class BracesValidator
{
    public static function validate(string $input)
    {
        $braces = 0;

        if (!empty($input)) {
            for ($i = 0; $i < strlen($_POST['string']); $i++) {
                if ($input[$i] === '(') {
                    ++$braces;
                } elseif ($input[$i] === ')') {
                    --$braces;
                }

                if ($braces < 0) {
                    throw new \InvalidArgumentException('Excessive closing braces');
                }
            }

            if ($braces !== 0) {
                throw new \InvalidArgumentException('Closing braces amount does not match opening braces amount');
            }
        }
    }
}
