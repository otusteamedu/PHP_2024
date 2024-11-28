<?php

declare(strict_types=1);

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */

    function hasCycle($head) {
        while(!is_null($head)) {
            if(!empty($hash) && in_array($head, $hash)) {
                return true;
            }
            $hash[] = $head;
            $head = $head->next;
        }

        return false;
    }
}