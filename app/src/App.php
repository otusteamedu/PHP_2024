<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusMergeListApp;

class App
{
    public function run(): void
    {
        // Вариант, когда заполнены оба списка
        $listNode1 = new ListNode(1, new ListNode(2, new ListNode(4)));
        $listNode2 = new ListNode(1, new ListNode(3, new ListNode(4)));
        $response = Solution::mergeTwoLists($listNode1, $listNode2);
        var_dump($response);

        // Вариант, когда оба списка пусты
        $response = Solution::mergeTwoLists(null, null);
        var_dump($response);

        // Вариант, когда заполнен только один из списков
        $response = Solution::mergeTwoLists(null, new ListNode(0));
        var_dump($response);
    }
}
