<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\Hw14\{LinkedListCycle, LinkedList};

$solution = new LinkedListCycle();
$head = (new LinkedList())->getList();

echo 'RESULT: ' . ($solution->hasCycle($head)
    ? 'В связанном списке есть цикл!'
    : 'В связанном списке нет цикла!') . PHP_EOL;
