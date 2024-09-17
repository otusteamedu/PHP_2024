<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\Hw14\Phone;

$digits = $_SERVER['argv'][1] ?? null;

print_r((new Phone())->letterCombinations($digits));
