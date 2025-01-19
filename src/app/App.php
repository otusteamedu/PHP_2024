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
//        $firstList = static::createLinkedList([1, 2, 4]);
//
//        $secondList = static::createLinkedList([1, 3, 4]);
//
//        $mergedLists = MergedLists::mergeTwoLists($firstList->head, $secondList->head);
//
//        static::printResult($mergedLists);

        $cycledListHead = static::createCycledLinkedList([1, 2, 3, 4], 1);

        var_dump(CycledListSolution::hasCycle($cycledListHead));
    }

    public static function createLinkedList(array $arr = []): LinkedList
    {
        $list = new LinkedList();

        foreach ($arr as $value) {
            $list->append($value);
        }

        return $list;
    }

    public static function createCycledLinkedList(array $arr, int $pos = 0): ?ListNode
    {
        if (empty($arr)) {
            return null;
        }

        $head = new ListNode($arr[0]);
        $current = $head;

        for ($i = 1; $i < count($arr); $i++) {
            $newNode = new ListNode($arr[$i]);
            $current->next = $newNode;
            $current = $newNode;

            if ($pos > 0 && $pos === $i) {
                $head = $newNode;
            }
        }

        // Point the last node to the head, creating a cycle
        $current->next = $head;

        return $head;
    }

    public static function printResult(?ListNode $result): void
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
