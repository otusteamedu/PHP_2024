<?php
declare(strict_types=1);

class ListNode
{
    public int $val;
    public ?ListNode $next = null;

    function __construct(int $val, ?self $next = null)
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

    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $newListHead = null;
        $newListTail = null;

        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                // значение меньше в списке 1
                if (empty($newListHead)) {
                    $newListHead = $list1;
                    $newListTail = $newListHead;
                    $list1 = $list1->next;
                    $newListTail->next = null;
                } else {
                    $newListTail->next = $list1;//
                    $newListTail = $newListTail->next;
                    $list1 = $list1->next; //
                    $newListTail->next = null;
                }
            } else {
                // значение меньше в списке 2
                if (empty($newListHead)) {
                    $newListHead = $list2;
                    $newListTail = $newListHead;
                    $list2 = $list2->next;
                    $newListTail->next = null;
                } else {
                    $newListTail->next = $list2;
                    $newListTail = $newListTail->next;
                    $list2 = $list2->next;
                    $newListTail->next = null;
                }
            }
        }

        // на выходе из цикла, один из списков, точно пустой. Если есть НЕ пустой, то пристыковываем его к новому списку.
        // при этом теряем хвост нового списка. Да он и не нужен.
        if (!$list1 && $list2) {
            if ($newListHead) {
                $newListTail->next = $list2;
            } else {
                $newListHead = $list2;
            }
            $list2 = null;
        }
        if (!$list2 && $list1) {
            if ($newListHead) {
                $newListTail->next = $list1;
            } else {
                $newListHead = $list1;
            }
            $list1 = null;
        }
        $newListTail = null;

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
