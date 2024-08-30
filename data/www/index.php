<?php

try {
    if (
        !isset($_POST['string'])
        || empty($string = trim($_POST['string']))
    ) {
        throw new Exception("Bad Request");
    }

    $counter = 0;
    foreach (str_split($string) as $letter) {
        if ($letter == '(') ++$counter;
        if ($letter == ')') --$counter;
        if ($counter < 0) {
            throw new Exception("Bad Request");
        }
    }

    if ($counter !== 0) {
        throw new Exception("Bad Request");
    }

    header("HTTP/1.1 200 It`s OK");
} catch (\Throwable $th) {
    header("HTTP/1.1 400 " . $th->getMessage());
}
