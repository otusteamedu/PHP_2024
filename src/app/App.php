<?php

declare(strict_types=1);

namespace App;

use App\ListNode;
use App\LinkedList;
use App\MergedLists;

class App
{
    public static function run(): void
    {
        $firstList = static::createLinkedList([1, 2, 4]);

        $secondList = static::createLinkedList([1, 3, 4]);

        $mergedLists = MergedLists::mergeTwoLists($firstList->head, $secondList->head);

        static::printResult($mergedLists);
    }

    public static function createLinkedList(array $arr = []): LinkedList
    {
        $list = new LinkedList();

        foreach ($arr as $value) {
            $list->append($value);
        }

        return $list;
    }

    public static function printResult(?ListNode $result): void
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
