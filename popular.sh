#!/bin/bash
#предполагаем, что комбинации записей user-city дожны быть разные
#то есть посещение несколько раз одного города одним пользователем при итоговом суммирование будет, как одно посещение

FILE='table.txt'

if ! [[ -f $FILE ]]; then
    echo "Файл '$FILE' не найден"
    exit 1
fi

awk '(NR>1) {print $2, $3}' $FILE | sort -k2 | uniq -i | awk '{print $2}' | uniq -c | sort -r | head -3