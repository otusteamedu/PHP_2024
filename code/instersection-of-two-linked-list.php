<?php

/**
 * @param ListNode $headA
 * @param ListNode $headB
 * @return ListNode|null
 */
function getIntersectionNode($headA, $headB) {
    if ($headA === null || $headB === null) {
        return null;
    }

    $ptrA = $headA;
    $ptrB = $headB;

    // Если указатели не пересеклись, каждый пройдет путь:
    // длина A + длина B (включая общую часть)
    while ($ptrA !== $ptrB) {
        // Если достигли конца списка A, переходим к началу списка B
        $ptrA = $ptrA === null ? $headB : $ptrA->next;

        // Если достигли конца списка B, переходим к началу списка A
        $ptrB = $ptrB === null ? $headA : $ptrB->next;
    }

    // ptrA = ptrB, это либо точка пересечения, либо null (если пересечения нет)
    return $ptrA;
}

/**
 * Временная сложность: O(n+m), где n и m - длины двух списков
 * Пространственная сложность: O(1), так как мы используем только несколько переменных
 */
