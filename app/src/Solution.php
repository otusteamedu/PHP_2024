<?php

declare(strict_types=1);

namespace Lrazumov\Hw19;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head): bool {
        if (is_null($head->next)) {
            return FALSE;
        }
        elseif (is_null($head->val)) {
            return TRUE;
        }
        $head->val = NULL;
        return $this->hasCycle($head->next);
    }
}
