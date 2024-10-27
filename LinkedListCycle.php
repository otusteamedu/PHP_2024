/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        if ($head === null) {
            return false; // Условие: если голова пустая, то цикл отсутствует
        }

        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next; // Двигаемся на один шаг
            $fast = $fast->next->next; // Двигаемся на два шага

            if ($slow === $fast) {
                return true; // Цикл найден
            }
        }

        return false; // Цикла нет
    }
}
