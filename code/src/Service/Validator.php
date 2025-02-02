<?php

declare(strict_types=1);

namespace DudkinIv\TestPackage\Service;

class Validator

{
    public function validateString(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $count = 0;
        $isBad = false;
        for ($i = 0; $i < strlen($string); $i++) {
            if ($count < 0) {
                return false;
            }
            switch ($string[$i]) {
                case "(";
                    $count++;
                    break;

                case ")";
                    $count--;
                    break;

                default;
                    return false;
            }
        }

        if ($isBad || $count !== 0) {
            http_response_code(400);
            return false;
        } else {
            return true;
        }
    }
}
