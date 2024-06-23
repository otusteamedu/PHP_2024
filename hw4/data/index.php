<?php

if ($_POST['string'] == "") {
    echo 'no value';
} else {
    $isValid = isValid($_POST['string']);
    if ($isValid) {
        echo "string is valid";
    } else {
        header('HTTP/1.1 400');
        echo "string is not valid";
    }
}

function isValid($str): bool
{
    $star = 0;
    $open = [];
    $len = strlen($str);

    for ($i = 0; $i < $len; ++$i) {
        if ($str[$i] == ')') {
            if (count($open) > 0) {
                array_pop($open);
            } elseif ($star > 0) $star--;
            else return false;
        } elseif ($str[$i] == '(') {
            array_push($open, $i);
        } else {
            $star++;
        }
    }

    if (count($open) === 0) return true;
    // check leftover open braces from the back
    $star = $ptr = 0;
    $open = array_reverse($open);

    for ($i = $len - 1; $i >= 0 && $ptr < count($open); --$i) {
        if ($str[$i] == '*') {
            $star++;
        } else if ($i == $open[$ptr]) {
            if ($star == 0) {
                return false;
            }
            $star--;
            $ptr++;
        }
    }

    return true;
}
