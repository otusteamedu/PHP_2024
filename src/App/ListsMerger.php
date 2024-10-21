<?php

namespace VSukhov\Hw8\App;

class ListsMerger
{
    /**
     * @param NodeList|null $list1
     * @param NodeList|null $list2
     *
     * @return NodeList|null
     */
    public static function merge(?NodeList $list1, ?NodeList $list2): ?NodeList
    {
        $empty = new NodeList();
        $current = $empty;

        while (isset($list1, $list2)) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        $current->next = $list1 ?? $list2;
        return $empty->next;
    }
}