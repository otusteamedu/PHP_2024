<?php

declare(strict_types=1);

namespace JuliaZhigareva\OtusComposerPackage;

/**
 *
 * Временная сложность: O(n)
 * Алгоритм выполняет итерацию по каждому узлу в обоих входных списках по одному разу,
 * что делает его линейным. Следовательно, временная сложность равна O(n),
 * где n - общее количество узлов во входных списках.
 */
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $head = new ListNode();
        $current = $head;
        while ($list1 !== null and $list2 !== null) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }

            $current = $current->next;
        }


        if ($list1 !== null) {
            $current->next = $list1;
        } elseif ($list2 !== null) {
            $current->next = $list2;
        }

        return $head->next;
    }
}
