<?php

use AlexanderPogorelov\Algorithm\LetterCombinator;
use AlexanderPogorelov\Algorithm\ListNode;
use AlexanderPogorelov\Algorithm\CycledListDetector;

require __DIR__ . '/vendor/autoload.php';

$detector = new CycledListDetector();
$combinator = new LetterCombinator();

$list = ListNode::createFromArray([ 3, 2, 0, -4 ]);
var_dump($detector->hasCycle($list));

$list = ListNode::createCycledFromArray([ 3, 2, 0, -4 ], 1);
var_dump($detector->hasCycle($list));

$list = ListNode::createFromArray([ 1, 2 ]);
var_dump($detector->hasCycle($list));

$list = ListNode::createCycledFromArray([ 1, 2 ], 0);
var_dump($detector->hasCycle($list));

$list = ListNode::createFromArray([ 1 ]);
var_dump($detector->hasCycle($list));

$list = ListNode::createCycledFromArray([ 1 ], -1);
var_dump($detector->hasCycle($list));

echo '---------------------------------------------------------------';

$digits = '23';
print_r($combinator->letterCombinations($digits));

$digits = '234';
print_r($combinator->letterCombinations($digits));

$digits = '2349';
print_r($combinator->letterCombinations($digits));

$digits = '';
print_r($combinator->letterCombinations($digits));

$digits = '2';
print_r($combinator->letterCombinations($digits));
