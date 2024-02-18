<?php

declare(strict_types=1);

function getStatusHeader(string $status): string
{
    return "HTTP/1.1 $status";
}

function sendGoodResponse(): void
{
    header(getStatusHeader('200 OK'));
    echo 'All right!';
};

function sendBadResponse(): void
{
    header(getStatusHeader('400 Bad Request'));
    echo 'Wrong string!';
};

$string = preg_replace('/\s+/', '', $_POST['string'] ?? '');

if ($string === '') {
    sendBadResponse();
    return;
};

$left = '(';
$right = ')';
$stack = [];

foreach (str_split($string) as $parenthesis) {
    if ($parenthesis === $left) {
        array_push($stack, $parenthesis);
    } elseif ($parenthesis === $right) {
        $char = array_pop($stack);

        if ($char === null || "{$char}{$parenthesis}" !== "{$left}{$right}") {
            sendBadResponse();
            return;
        }
    } else {
        sendBadResponse();
        return;
    }
}

sendGoodResponse();
