<?php

namespace Src;

class LinkedList {
    public static function getIntersectionNode($headA, $headB) {
        if ($headA === null || $headB === null) {
            return null; // Нет пересечения, если один из списков пуст
        }

        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = ($pointerA === null) ? $headB : $pointerA->next;
            $pointerB = ($pointerB === null) ? $headA : $pointerB->next;
        }

        return $pointerA; // Возвращает узел пересечения или null
    }
}