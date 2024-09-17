<?php

namespace ANaimushina;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        $head = new ListNode();
        $currentNodeFirst = $list1;
        $currentNodeSecond = $list2;
        $currentNodeMerged = $head;

        while ($currentNodeFirst && $currentNodeSecond) {
            $firstValue = $currentNodeFirst->val;
            $secondValue = $currentNodeSecond->val;

            if ($firstValue > $secondValue) {
                $currentNodeMerged->next = $currentNodeSecond;
                $currentNodeSecond = $currentNodeSecond->next;
            } else {
                $currentNodeMerged->next = $currentNodeFirst;
                $currentNodeFirst = $currentNodeFirst->next;
            }
            $currentNodeMerged = $currentNodeMerged->next;
        }

        $tail = $currentNodeFirst ?? $currentNodeSecond;
        if ($tail) {
            $currentNodeMerged->next = $tail;
        }

        return $head->next;
    }
}

/**
 * Вычислительная сложность - О(n)
 * Так как мы проходимся одновременно по обоим массивам, сложность будет расти пропорционально
 * размерам переданных массивов
 */
