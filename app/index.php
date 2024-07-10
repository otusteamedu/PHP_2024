<?php

header('Content-Type: application/json; charset=utf-8');

$response = [];

$openingBraces = 0;
$closingBraces = 0;

if (!empty($_POST['string'])) {
    try {
        $givenString = $_POST['string'];
        for ($i = 0; $i < strlen($_POST['string']); $i++) {
            if ($givenString[$i] === '(') {
                ++$openingBraces;
            } elseif ($givenString[$i] === ')') {
                ++$closingBraces;
            }

            if ($closingBraces > $openingBraces) {
                throw new InvalidArgumentException('Excessive closing braces');
            }
        }

        if ($closingBraces !== $openingBraces) {
            throw new InvalidArgumentException('Closing braces amount does not match opening braces amount');
        }

        $response = ['message' => 'OK'];
    } catch (\InvalidArgumentException $e) {
        http_response_code(400);
        $response = ['message' => $e->getMessage()];
    }

    echo json_encode($response);
}
