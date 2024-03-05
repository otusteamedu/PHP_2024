<?php

class ListNode
{
    public int|float $val = 0;
    public ?ListNode $next = null;

    /**
     * @param int|float $val
     * @param $next
     */
    function __construct(int|float $val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{
    /**
     * Сложность алгоритма - O(n), т. к. с увеличением кол-ва данных, кол-во итераций цикла while возрастает линейно
     *
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        // Определяем первую ноду и сохраняем её в переменные $current и $head
        if (null === $list1) {
            if (null === $list2) {
                return null;
            }
            $head = $current = $list2;
            $list2 = $list2->next;
        } else {
            if (null === $list2) {
                $head = $current = $list1;
                $list1 = $list1->next;
            } else {
                if ($list1->val < $list2->val) {
                    $head = $current = $list1;
                    $list1 = $list1->next;
                } else {
                    $head = $current = $list2;
                    $list2 = $list2->next;
                }
            }
        }

        // Перебираем ноды, до тех пор пока оба указателя не будут null (null - достигнут конец списка)
        while (null !== $list1 || null !== $list2) {
            if (null === $list1) {
                $current = $current->next = $list2;
                $list2 = $list2->next;
                continue;
            } else if (null === $list2) {
                $current = $current->next = $list1;
                $list1 = $list1->next;
                continue;
            }

            if ($list1->val > $list2->val) {
                $current = $current->next = $list2;
                $list2 = $list2->next;
            } else {
                $current = $current->next = $list1;
                $list1 = $list1->next;
            }
        }

        return $head;
    }
}

$chain1 = new ListNode(-5, new ListNode(1, new ListNode(33, null)));
$chain2 = new ListNode(0, new ListNode(23, null));

//$chain1 = new ListNode(-5, new ListNode(1, null));
//$chain2 = new ListNode(0, new ListNode(23, null));

//$chain1 = new ListNode(-5, new ListNode(1, null));
//$chain2 = new ListNode(5, new ListNode(10, null));

//$chain1 = null;
//$chain2 = null;

$sol = new Solution();

$result = $sol->mergeTwoLists($chain1, $chain2);

var_dump($result);
