<?php

declare(strict_types=1);

use App\Solution;

require __DIR__ . '/vendor/autoload.php';

$a = new Solution();
print_r($a->letterCombinations("23"));
