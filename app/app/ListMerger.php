<?php

declare(strict_types=1);

namespace Rmulyukov\Hw8;

final class ListMerger
{
    public function merge(LinkedList $list1, LinkedList $list2): LinkedList
    {
        $first = $list1;
        $second = $list2;
        if ($list1->getValue() > $list2->getValue()) {
            $first = $list2;
            $second = $list1;
        }
        $head = $first;

        while (true) {
            if (!$second) {
                break;
            }
            $firstNext = $first->getNext();
            if (!$firstNext) {
                $first->setNext($second);
                break;
            }
            if ($firstNext->getValue() > $second->getValue()) {
                $first->setNext($second);
                $second = $firstNext;
            }
            $first = $first->getNext();
        }

        return $head;
    }
}
