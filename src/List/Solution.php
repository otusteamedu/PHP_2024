<?php

namespace VladimirGrinko\List;

use VladimirGrinko\List\ListNode;

class Solution
{
    /*
    Сложность алгоритма - O(n). n - длина списка
    То есть при наихудшем сценарии достаточно будет одного прохода $head по списку, чтобы найти цикличность
    */
    public function hasCycle(ListNode $head): bool
    {
        $fast = $head;
        while ($fast && $fast->next) {
            $head = $head->next;
            $fast = $fast->next->next;
            if ($fast === $head) {
                return true;
            }
        }
        return false;
    }
}
