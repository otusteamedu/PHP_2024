<?php

require __DIR__ . '/vendor/autoload.php';
use EkaterinaKonyaeva\OtusComposerApp\Application\Task1\Solution as Task1;
use EkaterinaKonyaeva\OtusComposerApp\Application\Task2\Solution;
use EkaterinaKonyaeva\OtusComposerApp\Application\Task2\ListNode;

$digits = new Task1();
$result =  $digits->letterCombinations('23');
echo '<pre>';
print_r($result);
echo '</pre>';

$result =  $digits->letterCombinations('');
echo '<pre>';
print_r($result);
echo '</pre>';

$result =  $digits->letterCombinations('2');
echo '<pre>';
print_r($result);
echo '</pre>';


// Создание связанного списка [1,2] с циклом
$head2 = new ListNode(2);
$head1 = new ListNode(1, $head2);
$head2->next = $head1;

$solution = new Solution();
if ($solution->hasCycle($head1)) {
    echo "Связанный список имеет цикл.<br>";
} else {
    echo "Связанный список не имеет цикла.<br>";
}

// Создание связанного списка [3, 2, 0, -4] с циклом
$head4 = new ListNode(-4);
$head3 = new ListNode(0, $head4);
$head2 = new ListNode(2, $head3);
$head1 = new ListNode(3, $head2);
$head4->next = $head2;

if ($solution->hasCycle($head1)) {
    echo "Связанный список имеет цикл.<br>";
} else {
    echo "Связанный список не имеет цикла.<br>";
}

// Создание связанного списка 1 без цикла
$head = new ListNode(1);
if ($solution->hasCycle($head)) {
    echo "Связанный список имеет цикл.<br>";
} else {
    echo "Связанный список не имеет цикла.";
}

