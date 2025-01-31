<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusMergeListApp;

class Solution
{
    /**
     * @param ?ListNode $list1
     * @param ?ListNode $list2
     *
     * @return ?ListNode
     */
    public static function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        // Создаем новый экземпляр класса для объединенных данных
        $result = new ListNode();
        $currentList = $result;

        // Выполняем итерацию, пока один из списков не будет пуст
        while (!is_null($list1) && !is_null($list2)) {
            // Сравниваем значения из двух списков и добавляем наименьший в результрующий объект
            // отсекаем элементы по одному
            if ($list1->val < $list2->val) {
                $currentList->next = $list1;
                $list1 = $list1->next;
            } else {
                $currentList->next = $list2;
                $list2 = $list2->next;
            }

            $currentList = $currentList->next;
        }


        // Если остались элементы списка, то добавляем их к объединенному объекту
        if ($list1 !== null) {
            $currentList->next = $list1;
        } elseif ($list2 !== null) {
            $currentList->next = $list2;
        }

        // Выводим объединенный объект
        return $result->next;
    }
}
