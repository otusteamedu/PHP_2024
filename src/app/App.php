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


        // Intersection of Two Linked Lists
        $intersectVal = 8;
        [$listA, $listB] = static::createIntersectingLinkedLists($intersectVal);
        $intersection = IntersectionNodeSolution::getIntersectionNode($listA->head, $listB->head);

        // Fraction to Recurring Decimal
        $numerator = 1;
        $denominator = 2;
        $decimal = FractionToDecimalSolution::fractionToDecimal($numerator, $denominator);

        echo '<pre>';
        var_dump($intersection);
        echo '</pre>' . PHP_EOL;

        static::printResult([$decimal]) . PHP_EOL;
    }

    public static function createLinkedList(array $arr = []): LinkedList
    {
        $list = new LinkedList();

        foreach ($arr as $value) {
            $list->append($value);
        }

        return $list;
    }

    public static function createIntersectingLinkedLists($intersectVal): array
    {
        // Создаем первый Linked List
        $listA = new LinkedList();
        $listA->append(4);
        $listA->append(1);

        // Создаем узел пересечения
        $intersectNode = new ListNode($intersectVal);
        $listA->appendNode($intersectNode);

        $listA->append(4);
        $listA->append(5);

        // Создаем второй Linked List
        $listB = new LinkedList();
        $listB->append(5);
        $listB->append(6);
        $listB->append(1);

        // Связываем второй Linked List с узлом пересечения
        $listB->appendNode($intersectNode);

        return [$listA, $listB];
    }

    public static function printResult(ListNode|array|null $result): void
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
