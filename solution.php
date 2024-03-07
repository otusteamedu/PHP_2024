<?php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }

    /**
     * Добавляет следующую ноду по её значению и возвращает её (для цепочного вызова)
     * @note Добавлено для быстрого заполнения тестовыми значениями, в реализуемом методе mergeTwoLists не используется
     * @param int $val
     * @return self
     */
    function addNextByValue(int $val = 0): self
    {
        $nextNode = new self($val);
        $this->next = $nextNode;
        return $this->next;
    }

    /**
     * Добавляет следующие ноды по значениям из массива
     * @note Добавлено для быстрого заполнения тестовыми значениями, в реализуемом методе mergeTwoLists не используется
     * @param array $values
     * @return $this
     */
    function addNextByValuesArray(array $values): self
    {
        $currentNode = $this;
        foreach ($values as $value) {
            $currentNode = $currentNode->addNextByValue($value);
        }
        return $this;
    }
}

class Solution
{
    /**
     * Слить два ListNode по возрастанию
     * @param ListNode|null $list1 отсортированный по val список
     * @param ListNode|null $list2 отсортированный по val список
     * @return ListNode|null
     * @throws Exception
     */
    function mergeTwoLists(?ListNode $list1 = null, ?ListNode $list2 = null): ?ListNode
    {
        if (!$list2) return $list1;
        if (!$list1) return $list2;

        $mergedList = new ListNode($this->getMinValueAndShiftList($list1, $list2));
        $lastNode = $mergedList;
        while (!is_null($list1) && !is_null($list2)) {
            $nextValue = $this->getMinValueAndShiftList($list1, $list2);
            if ($nextValue < $lastNode->val) throw new Exception('Переданы не отсортированные по возрастанию списки');
            $lastNode->next = new ListNode($nextValue);
            $lastNode = $lastNode->next;
        };

        if ($list1) {
            $lastNode->next = $list1;
        } elseif ($list2) {
            $lastNode->next = $list2;
        }

        return $mergedList;
    }

    /**
     * Получить минимальное значение из двух нод и сдвинуть эту ноду на next
     * @param ListNode $list1
     * @param ListNode $list2
     * @return int|null
     */
    private function getMinValueAndShiftList(ListNode &$list1, ListNode &$list2): ?int
    {
        if ($list1->val < $list2->val) {
            $result = $list1->val;
            $list1 = $list1->next;
        } else {
            $result = $list2->val;
            $list2 = $list2->next;
        }
        return $result;
    }
}


$solution = new Solution();

$listFirst = new ListNode(2);
$listFirst->addNextByValue(3)->addNextByValue(4)->addNextByValue(22)->addNextByValue(44)->addNextByValue(77)->addNextByValue(88)->addNextByValue(89);
$listSecond = new ListNode(1);
$listSecond->addNextByValue(8)->addNextByValue(10)->addNextByValue(27)->addNextByValue(50)->addNextByValue(88);
var_dump($solution->mergeTwoLists($listFirst, $listSecond));


$listThird = new ListNode(1);
$listThird->addNextByValuesArray([2,4,5,6,9,14,16,18,34,54,67,67,88,89,93]);
$listFourth = new ListNode(2);
$listFourth->addNextByValuesArray([3,4,5,7,9,10,14,14,16,18,33,34,35,36,37,37,37,37,54,67,88,89,93,94]);
var_dump($solution->mergeTwoLists($listThird, $listFourth));