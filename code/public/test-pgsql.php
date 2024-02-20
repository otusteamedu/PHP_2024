<?php

$dsnStr = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    'postgresql',
    '5432',
    'hukimato',
    'hukimato',
    'hukimato'
);

try {
    $dbh = new PDO($dsnStr);
    echo "Подключилось успешно" . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
