<?php
/**
 * Сложность O(M+N) -
 * M длина первого списка
 * N длина второго списка
 **/
function getIntersectionNode($headA, $headB)
{
    $hashA = [];
    $currentA = $headA;
    while ($currentA) {
        $hashA[spl_object_hash($currentA)] = $currentA;
        $currentA = $currentA->next;
    }

    $currentB = $headB;
    while ($currentB) {
        if ($hashA[spl_object_hash($currentB)]) {
            return $currentB;
        }
        $currentB = $currentB->next;
    }
    return null;
}

/**
 * Сложность O(N)
 **/
function getIntersectionNodeV2($headA, $headB)
{
    $pointerA = $headA;
    $pointerB = $headB;
    while ($pointerA !== $pointerB) {
        $pointerA = $pointerA ? $pointerA->next : $headB;
        $pointerB = $pointerB ? $pointerB->next : $headA;

    }
    return $pointerA;
}
