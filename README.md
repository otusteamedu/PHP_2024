# Описание работы

## Linked list cycle

https://leetcode.com/problems/linked-list-cycle/

Сложность алгоритма получается O(n).
Потому что при отсутствии цикла быстрый список пройдет за O(n/2).
А в худшем случае мы пройдем список примерно дважды O(n+n).

Используемая память O(1). Потому что используются только 2 списка.

LeetCode данное решение принял.

Проверка

```shell
docker exec -ti otus-php-app php linked-list-cycle.php
```

## Letter Combinations of a Phone Number

https://leetcode.com/problems/letter-combinations-of-a-phone-number/

Сложность алгоритма получается O(4n). Где n количество цифр.
В худшем случае такие цифры как 7 и 9 добавляют по 4 буквы.

По памяти получается так же O(4n). Для хранения всех комбинаций.

LeetCode данное решение принял.

Проверка

```shell
docker exec -ti otus-php-app php letter-combinations-of-a-phone-number.php
```


