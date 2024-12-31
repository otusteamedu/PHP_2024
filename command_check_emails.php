<?php

$isCli = php_sapi_name() === 'cli';

if ($isCli) {
    $pathToEmails = !empty($argv[1]) && file_exists($argv[1])
        ? $argv[1]
        : (file_exists('emails.txt') ? 'emails.txt' : null);

    $validEmailAddresses = [];
    $notValidEmailAddresses = [];
    if (!empty($pathToEmails)) {
        foreach (getLines($pathToEmails) as $email) {
            if (checkEmail($email)) {
                $validEmailAddresses[] = $email;
            } else {
                $notValidEmailAddresses[] = $email;
            }
        }
    }

    $result = 'Валидные email (' . count($validEmailAddresses) . ' шт.):' . PHP_EOL;
    $result .= implode(PHP_EOL, $validEmailAddresses) . PHP_EOL . PHP_EOL;

    $result .= 'Не валидные email (' . count($notValidEmailAddresses) . ' шт.):' . PHP_EOL;
    $result .= implode(PHP_EOL, $notValidEmailAddresses) . PHP_EOL;

    echo $result;
}

function getLines(string $file): Generator
{
    $f = fopen($file, 'r');
    while ($line = trim(fgets($f))) {
        if (empty($line)) {
            continue;
        }
        yield $line;
    }
    fclose($f);
}

function checkEmail(string $email): bool
{
    $result = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($result) {
        $domain = explode('@', $email)[1];
        $result = checkdnsrr($domain . '.');
    }

    return $result;
}
