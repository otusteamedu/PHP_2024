<?php

declare(strict_types=1);

namespace App;

class Solution
{
    public static function hasCycle(?ListNode $list): bool
    {
        if ($list === null || $list->next === null) {
            return false;
        }

        $slow = $list;
        $fast = $list->next;

        while ($slow !== $fast) {
            if ($fast === null || $fast->next === null) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}
