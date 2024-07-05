<?php

function mergeTwoLists($list1, $list2)
{
    if (!$list1) {
        return $list2;
    }

    if (!$list2) {
        return $list1;
    }

    if ($list1->val < $list2->val) {
        $head = $list1;
        $list1 = $list1->next;
    } else {
        $head = $list2;
        $list2 = $list2->next;
    }

    $current = $head;

    while ($list1 && $list2) {
        if ($list1->val < $list2->val) {
            $current->next = $list1;
            $list1 = $list1->next;
        } else {
            $current->next = $list2;
            $list2 = $list2->next;
        }
        $current = $current->next;
    }

    if ($list1) {
        $current->next = $list1;
    } else {
        $current->next = $list2;
    }

    return $head;
}
