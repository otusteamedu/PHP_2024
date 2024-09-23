<?php

declare(strict_types=1);

// Сложность O(n) - пепребираем n элементов, выходим при повторе;
class Solution
{
    function hasCycle($head)
    {
        $hash = [];
        $node = $head;
        while ($node && !isset($hash[spl_object_id($node)])) {
            $hash[spl_object_id($node)] = true;
            $node = $node->next;
        }
        if (isset($node->next)) {
            return true;
        }
        return false;
    }
}
