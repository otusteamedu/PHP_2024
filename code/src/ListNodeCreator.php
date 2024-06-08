<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm2;

class ListNodeCreator
{
    public static function createFromArray(array $data): ?ListNode
    {
        $length = count($data);

        if (0 === $length) {
            return null;
        }

        $list = $current = new ListNode($data[0]);

        for ($i = 1; $i < $length; $i++) {
            $current->setNext(new ListNode($data[$i]));
            $current = $current->getNext();
        }

        return $list;
    }

    public static function createCycledFromArray(array $data, int $position): ?ListNode
    {
        $length = count($data);

        if (0 === $length) {
            return null;
        }

        if ($position < 0 || $position >= $length) {
            return null;
        }

        $list = $current = $cycledNode = new ListNode($data[0]);
        $lastNodeIndex = $length - 1;

        for ($i = 1; $i < $length; $i++) {
            $current->setNext(new ListNode($data[$i]));
            $current = $current->getNext();

            if ($i === $position) {
                $cycledNode = $current;
            }

            if ($i === $lastNodeIndex) {
                $current->setNext($cycledNode);
            }
        }

        return $list;
    }

    /**
     * @throws \Exception
     */
    public static function createIntersectedListNodes(array $listA, array $listB, int $skipA, int $skipB): TwoListNodesDto
    {
        $lengthA = count($listA);
        $lengthB = count($listB);

        if (0 === $lengthA || 0 === $lengthB) {
            throw new \Exception('Not valid list data');
        }

        if (0 > $skipA || 0 > $skipB) {
            throw new \Exception('Not valid skip data');
        }

        if (!isset($listA[$skipA]) || !isset($listB[$skipB]) || $listA[$skipA] !== $listB[$skipB]) {
            return new TwoListNodesDto(self::createFromArray($listA), self::createFromArray($listB));
        }

        $headA = array_slice($listA, 0, $skipA);
        $headB = array_slice($listB, 0, $skipB);

        if (0 === count($headA) && 0 === count($headB)) {
            return new TwoListNodesDto(self::createFromArray($listA), self::createFromArray($listB));
        }

        $tailA = array_slice($listA, $skipA);
        $tailB = array_slice($listB, $skipB);

        if ($tailA !== $tailB) {
            throw new \Exception('Not valid list data');
        }

        $lengthHeadA = count($headA);
        $lengthHeadB = count($headB);

        $tailListNode = self::createFromArray($tailA);
        $listNodeA = $currentA = new ListNode($listA[0]);
        $listNodeB = $currentB = new ListNode($listB[0]);

        for ($i = 1; $i < $lengthHeadA; $i++) {
            $currentA->setNext(new ListNode($listA[$i]));
            $currentA = $currentA->getNext();
        }

        for ($i = 1; $i < $lengthHeadB; $i++) {
            $currentB->setNext(new ListNode($listB[$i]));
            $currentB = $currentB->getNext();
        }

        $currentA->setNext($tailListNode);
        $currentB->setNext($tailListNode);

        return new TwoListNodesDto($listNodeA, $listNodeB);
    }
}
