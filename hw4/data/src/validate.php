<?php

function isValid($str): bool
{
    $chars = str_split($str);
    $count = 0;
    foreach ($chars as $char) {
        if ($char == '(') {
            $count++;
        }
        if ($char == ')') {
            $count--;
            if ($count < 0) {
                return false;
            }
        }
    }
    if ($count > 0) {
        return false;
    } else {
        return true;
    }
}
