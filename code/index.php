<?php

$PARAM_NAME = 'string';
$OPEN = '(';
$CLOSE = ')';
$cnt = 0;

$string =  $_POST[$PARAM_NAME];

if (strlen($string) == 0) error();

for ($i = 0; $i < strlen($string); $i++) {
    switch ($string[$i]) {
        case $OPEN: $cnt++; break;
        case $CLOSE: $cnt--; break;
        default: error();
    }
    if ($cnt < 0) error();
}
if ($cnt !== 0) {
    error();
}

function error()
{
    http_response_code(400); exit;
}