<?php

declare(strict_types=1);

namespace Rmulyukov\Hw8;

final class ListMerger
{
    function mergeTwoLists($list1, $list2) {
        if (!$list1) {
            return $list2;
        }
        if (!$list2) {
            return $list1;
        }

        if ($list2->val > $list1->val) {
            $head = $list1;
            $list1 = $list1->next;
        } else {
            $head = $list2;
            $list2 = $list2->next;
        }

        $last = $head;

        while (true) {
            if (!$list1) {
                $last->next = $list2;
                break;
            }
            if (!$list2) {
                $last->next = $list1;
                break;
            }
            if ($list2->val > $list1->val) {
                $last->next = $list1;
                $list1 = $list1->next;
            } else {
                $last->next = $list2;
                $list2 = $list2->next;
            }
            $last = $last->next;
        }

        return $head;
    }
}
