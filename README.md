# Алогоритмическая сложность:

Так как для расчета аналитической сложности берется наихудший случай - часть алгоритма, обрабатывающая частный случай пустоты одного или двух списков учитываться не будет.
```
if (!$list2) return $list1;
if (!$list1) return $list2;
```

Сложность заполнения списка тернарным оператором константная - $$O(1)$$
```
$resultList = ($list1->val < $list2->val) ? ListNode($list1->val) : new ListNode($list2->val);
```

Сложность ветвления так же - $$O(1)$$
```
if ($list1->val < $list2->val) {
	$list1 = $list1->next;
} else {
	$list2 = $list2->next;
}
```
Так как $$O(1) + O(1) = O(1)$$, и сложность операций внитри цикла не привышает $$O(1)$$, то итоговой сложностью цикла будет - $$O(n)$$
```
while (!is_null($list1) && !is_null($list2)) {
	$nextValue = ($list1->val < $list2->val) ? $list1->val : $list2->val;
        if ($list1->val < $list2->val) {
            $list1 = $list1->next;
        } else {
            $list2 = $list2->next;
        };

        $nextNode->next = new ListNode($nextValue);
        $nextNode = $nextNode->next;

        };
```

И снова ветвление с константной сложностью
```
if ($list1) {
	$nextNode->next = $list1;
} elseif ($list2) {
        $nextNode->next = $list2;
}
```

В итоге сложность алгоритма:
$$O(1) + O(1) + O(n) + O(1) = O(1 + 1 + n + 1) = O(n+3) = O(n)$$

Тикам образом, сложность всего алгоритма - линейная $$O(n)$$. 
