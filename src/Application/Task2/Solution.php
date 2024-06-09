<?php

namespace EkaterinaKonyaeva\OtusComposerApp\Application\Task2;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public static function hasCycle($head)
    {
        if ($head == null || $head->next == null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($slow != $fast) {
            if ($fast == null || $fast->next == null) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}