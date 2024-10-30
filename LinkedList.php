<?php

    // Временная сложность: O(n)
    // Пространственная сложность: O(1)
    class ListNode
    {
        public int $val = 0;
        public ?ListNode $next = null;

        public function __construct(int $val = 0, ListNode $next = null) {
            $this->val = $val;
            $this->next = $next;
        }
    }

    function hasCycle(ListNode $head): bool
    {
        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next;
            $fast = $fast->next->next;

            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }
