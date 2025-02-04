<?php

declare(strict_types=1);

namespace PavelMiasnov\Hw14\LinkedListCycle;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
/**
 * Сложность O(N), т.к. алгоритм осуществляет перебор N элементов списка.
 * Сложность по памяти: O(1), т.к. у нас определенное кол-во переменных.
 */
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head) {
        $h = $head;
        while($h) {
            if($h->val === null) {
                return true;
            }
            $h->val = null;
            $h = $h->next;
        }
        return false;
    }
}
