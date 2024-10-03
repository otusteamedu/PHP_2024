<?php

declare(strict_types=1);

namespace Otus\Leetcode\LinkedListCycle;

// Сложность O(n) т.к. алгоритм осуществляет перебор n элементов связного списка.
// Перебор завершается досрочно при наличии повторяющегося элемента.
use Otus\MergeTwoLists\ListNode;

class Solution
{
    /**
     * @param ListNode $head
     * @return bool
     */
    public function hasCycle(ListNode $head): bool
    {
        $hash = [];
        $node = $head;

        while ($node && !isset($hash[spl_object_id($node)])) {
            $hash[spl_object_id($node)] = true;
            $node = $node->next;
        }

        if (isset($node->next)) {
            return true;
        }

        return false;
    }
}
