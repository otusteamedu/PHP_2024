<?php

declare(strict_types=1);


class ListNode
{
    public $val = 0;
    public ?ListNode $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

// Сложность O(n)
class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public static function mergeTwoLists(ListNode $list1, ListNode $list2) {
        if (is_null($list1)) {
            return $list2;
        }

        if (is_null($list2)) {
            return $list1;
        }

        $topNode = new ListNode();
        $curNode = $topNode;

        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                $curNode->next = $list1;
                $list1 = $list1->next;
            } else {
                $curNode->next = $list2;
                $list2 = $list2->next;
            }
            $curNode = $curNode->next;
        }

        if (is_null($list1)) {
            $curNode->next = $list2;
        } else {
            $curNode->next = $list1;
        }

        return $topNode->next;
    }
}

function createList(array $arr1): ListNode
{
    $list1 = new ListNode($arr1[0]);
    $firstNode = $list1;
    for ($i = 1; $i < count($arr1); $i++) {
        $list1->next = new ListNode($arr1[$i]);
        $list1 = $list1->next;
    }
    return $firstNode;
}

function printList(ListNode $node)
{
    while (!is_null($node)) {
        echo $node->val.' -> ';
        $node = $node->next;
    }
    echo 'null'. PHP_EOL;
}

$arr1 = [1, 3, 5];
$arr2 = [2, 4, 6];


$list1 = createList($arr1);
$list2 = createList($arr2);

printList(Solution::mergeTwoLists($list1, $list2));
