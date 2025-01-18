<?php

use Den\Php2024\MergeService;
use Den\Php2024\NodeList;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $list1 = new NodeList(1, new NodeList(2, new NodeList(4)));
    $list2 = new NodeList(1, new NodeList(3, new NodeList(4)));

    echo PHP_EOL . "list1: $list1" . PHP_EOL;
    echo "list2: $list2" . PHP_EOL;
    echo 'result: ' . MergeService::mergeTwoList($list1, $list2) . PHP_EOL;

    $list3 = new NodeList();
    $list4 = new NodeList();

    echo PHP_EOL . "list1: $list3" . PHP_EOL;
    echo "list2: $list4" . PHP_EOL;
    echo 'result: ' . MergeService::mergeTwoList($list3, $list4) . PHP_EOL;

    $list5 = new NodeList();
    $list6 = new NodeList(0);

    echo PHP_EOL . "list1: $list5" . PHP_EOL;
    echo "list2: $list6" . PHP_EOL;
    echo 'result: ' . MergeService::mergeTwoList($list5, $list6) . PHP_EOL;
} catch (Exception $exception) {
    echo "Ошибка: {$exception->getMessage()}" . PHP_EOL;
}
