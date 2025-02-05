<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusLeetcodeApp;

class App
{
    public function run(): void
    {
        // Указываем числитель и знаменатель
        $numerator = 1;
        $denominator = 2;

        // Вызываем метод и на выходе получаем 0.5
        $response = Solution::fractionToDecimal($numerator, $denominator);
        print_r($response);

        // Указываем числитель и знаменатель
        $numerator = 2;
        $denominator = 1;

        // Вызываем метод и на выходе получаем 2
        $response = Solution::fractionToDecimal($numerator, $denominator);
        print_r($response);

        // Указываем числитель и знаменатель
        $numerator = 4;
        $denominator = 333;

        // Вызываем метод и на выходе получаем 0.(012)
        $response = Solution::fractionToDecimal($numerator, $denominator);
        print_r($response);

        // ---------------------------------------------------------------------------------------------------

        // Создаем первый связанный список [4,1,8,4,5]
        $list1 = new ListNode(4);
        $list1->next = new ListNode(1);
        $list1->next->next = new ListNode(8);
        $list1->next->next->next = new ListNode(4);
        $list1->next->next->next->next = new ListNode(5);

        // Создаем второй связанный список [4,1,8,4,5]
        $list2 = new ListNode(5);
        $list2->next = new ListNode(6);
        $list2->next->next = new ListNode(1);
        $list2->next->next->next = $list1->next->next;

        // Вызываем метод и на выходе получаем 8
        $response = Solution::getIntersectionNode($list1, $list2);
        print_r($response);

        // Создаем первый связанный список [1,9,1,2,4]
        $list1 = new ListNode(1);
        $list1->next = new ListNode(9);
        $list1->next->next = new ListNode(1);
        $list1->next->next->next = new ListNode(2);
        $list1->next->next->next->next = new ListNode(4);

        // Создаем второй связанный список [3,2,4]
        $list2 = new ListNode(3);
        $list2->next = $list1->next->next->next;

        // Вызываем метод и на выходе получаем 2
        $response = Solution::getIntersectionNode($list1, $list2);
        print_r($response);

        // Создаем первый связанный список [2,6,4]
        $list1 = new ListNode(2);
        $list1->next = new ListNode(6);
        $list1->next->next = new ListNode(4);

        // Создаем второй связанный список [1,5]
        $list2 = new ListNode(1);
        $list2->next = new ListNode(5);

        // Вызываем метод и на выходе получаем NULL
        $response = Solution::getIntersectionNode($list1, $list2);
        print_r($response);
    }
}
