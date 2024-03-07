<?php

declare(strict_types=1);

class ListNode
{
    public int $val;
    public ?ListNode $next = null;
    public function __construct(int $val, ?self $next = null)
    {
        $this->next = $next;
        $this->val = $val;
    }

    public function setNext(?self $next): ?self
    {
        return $this->next = $next;
    }
}

class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        // будем считать это "служебным" узлом. Теперь список изначально не пустой. Это сократит
        // кол-во проверок в цикле. Просто будем помнить, что первый узел, "фейковый".
        $newListHead = new ListNode(0);
        $newListTail = $newListHead;
        $newListTail->next = null;
        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                $newListTail->next = $list1;
                $list1 = $list1->next;
                $newListTail = $newListTail->next;
        // одинаковая строчка в обоих кейсах. Можно было бы вынести за пределы условия. Но тяжелее понять суть работы со списком. А на скорость не влияет.
            } else {
                $newListTail->next = $list2;
                $list2 = $list2->next;
                $newListTail = $newListTail->next;
            }
            // тут напрашивается $newListTail->next = null; , для того, что бы не нарушить правила списка.
            // А именно, последний элемент не должен иметь ссылку на следующий. На то он и последний.
            // Однако, на каждом проходе цикла, будет добавляться новый элемент.
        }

        // на выходе из цикла, один из списков, точно пустой. Если есть НЕ пустой, то пристыковываем его к новому списку.
        // при этом теряем хвост у нового списка. Да он и не нужен. Его и во входных данных то, не было).
        if ($list2) {
            $newListTail->next = $list2;
        } elseif ($list1) {
            $newListTail->next = $list1;
        } else {
        // если сюда провалится, то значит оба списка пустые. Например, если они изначально были пустые.
            // Возможно, провалится, еще при каких то случаях, которые я не предусмотрел.
            // тогда нам нечего пристыковывать, однако, надо гарантировать, что последний элемент без ссылки.
            $newListTail->next = null;
        }

        $newListHead = $newListHead->next;
// исключаем тот самый "служебный" элемент (добавили в начале)

        return $newListHead;
    }
}


$l1 = new ListNode(1);
$l1
->setNext(new ListNode(3))
->setNext(new ListNode(5))
->setNext(new ListNode(15))
->setNext(new ListNode(36));
$l2 = new ListNode(1);
$l2
->setNext(new ListNode(8))
->setNext(new ListNode(9))
->setNext(new ListNode(17))
->setNext(new ListNode(20));
//$l1 = null;
//$l2 = null;


$sol = new Solution();
$l3 = $sol->mergeTwoLists($l1, $l2);
while ($l3) {
    echo "{$l3->val}; ";
    $l3 = $l3->next;
}
