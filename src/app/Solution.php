<?php

declare(strict_types=1);

namespace App;

class Solution
{
    public static function hasCycle(?ListNode $list): bool
    {
        if ($list === NULL || $list->next === NULL) {
            return false;
        }

        $slow = $list;
        $fast = $list->next;

        while ($slow !== $fast) {
            if ($fast === NULL || $fast->next === NULL) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}
