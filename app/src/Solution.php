<?php

declare(strict_types=1);

namespace Lrazumov\Hw19;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        if (is_null($head->next)) {
            return false;
        } elseif (is_null($head->val)) {
            return true;
        }
        $head->val = null;
        return $this->hasCycle($head->next);
    }
}
