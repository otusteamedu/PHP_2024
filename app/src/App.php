<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusLeetcodeApp;

class App
{
    public function run(): void
    {
        // Создаем связанный список с циклом [3,2,0,-4]
        $list1 = new ListNode(3);
        $list2 = new ListNode(2);
        $list3 = new ListNode(0);
        $list4 = new ListNode(-4);

        // Устанавливаем связи в списке
        $list4->setNext($list2);
        $list3->setNext($list4);
        $list2->setNext($list3);
        $list1->setNext($list2);

        $response = Solution::hasCycle($list1);
        var_dump($response);

        // Создаем связанный список с циклом [1,2]
        $list1 = new ListNode(1);
        $list2 = new ListNode(2);

        // Устанавливаем связи в списке
        $list2->setNext($list1);
        $list1->setNext($list2);

        $response = Solution::hasCycle($list1);
        var_dump($response);

        // Создаем связанный цикл [1]
        $list1 = new ListNode(1);

        $response = Solution::hasCycle($list1);
        var_dump($response);

        // Выводим все возможные комбинации букв, на осонове
        // переданных чисел в виде строки
        $response = Solution::letterCombinations('678');
        var_dump($response);
    }
}
