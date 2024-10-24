# Алогоритмическая сложность:

## Linked List Cycle

Сложность приведенного ниже блока = $$O(1) + O(1) + O(n) = O(n), где n - длинна исходного массива$$
```phpt
$after = $head;
$before = $head->next;

while ($before != null)
```

Сложность тела цикла складывется из $$O(1)$$ - за объавление переменной, два $$O(1)$$ - условные конструкции, 
три переопрделения перменной сложнотьь которых - $$O(1)$$. 
Итого: $$O(1) + 2*O(1) + 3*O(1) = O(1)$$
```phpt
            $next = $before->next;

            if ($next == null) {
                return false;
            }

            if ($after === $before || $after === $next) {
                return true;
            }

            $before = $next;
            $after = $after->next;
            $before = $before->next;
```

#### Таким образом сложность алгоритма - $$O(n)$$ 



## Letter Combinations of a Phone Number

Сложность условной конструкции - $$O(1)$$
```phpt
if (empty($digits)) {
            return [];
        };
```

Cложность определения двух массивов - $$O(1)$$
```phpt
$buttons = [
'2' => ['a', 'b', 'c'],
'3' => ['d', 'e', 'f'],
'4' => ['g', 'h', 'i'],
'5' => ['j', 'k', 'l'],
'6' => ['m', 'n', 'o'],
'7' => ['p', 'q', 'r', 's'],
'8' => ['t', 'u', 'v'],
'9' => ['w', 'x', 'y', 'z']
];
$combinations=[''];
```

Сложность первого цикла - $$O(n)$$, где k - количество символов исходной строки,
cложность второго цикла - $$O(n)$$, где n - количество комбинаций ($$n = 3 * k$$),
cложность третьего цикла - $$O(n)$$, где k - количество символов исходной строки,
cложность четвертого цикла - $$O(m)$$, где m - количество символов массива ссотвествующих цифре исходного массива (будем считать равным 4).
Итого: $$O(k * n * k * m) = O(n^4)$$
```phpt
for ($i = 0; $i < strlen($digits); $i++) {
            $current_combination = [];
            foreach ($combinations as $combination) {
                foreach (str_split($digits[$i]) as $number) {
                    $number = (int) $number;
                    foreach ($buttons[$number] as $letter) {
                        $current_combination[] = $combination . $letter;
                    }
                }
            }
            $combinations = $current_combination;
        }
```

#### Таким образом сложность алгоритма - $$O(n^4)$$
