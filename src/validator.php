<?php

declare(strict_types=1);

namespace Validator;

function validateBracketsString(string $string): bool
{
    if ($string === '') {
        return false;
    };

    $match = preg_match('/[^\(|\)]+/', $string);

    if ($match === false || $match === 1) {
        return false;
    }

    return true;
}
