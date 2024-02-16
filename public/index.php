<?php

use AlexanderPogorelov\DateTimeHelper\DateHelper;

require dirname(__DIR__) . '/vendor/autoload.php';

$timezone = 'Europe/Minsk';
$helper = new DateHelper();

$nowString = $helper->getCurrentDateMySQL($timezone);
$nowObject = $helper->createDateFromString($nowString, $timezone);

echo "<pre>";
echo 'Current Date in MySQL format:' . PHP_EOL;
echo $nowString;
echo "<hr>";
echo 'Current Date as DateTimeImmutable object:';
print_r($nowObject);
echo "</pre>";
