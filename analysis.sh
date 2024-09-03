#!/bin/bash

check_utility() {
    if ! command -v "$1" &> /dev/null; then
        echo "Ошибка: утилита '$1' не установлена."
        exit 1
    fi
}

check_utility "awk"
check_utility "sort"
check_utility "uniq"
check_utility "head"

# Проверка на количество аргументов
if [ "$#" -ne 1 ]; then
    echo "Ошибка: требуется указать файл с таблицей данных."
    exit 1
fi

if [ ! -f "$1" ]; then
    echo "Ошибка: файл не найден."
    exit 1
fi

top_3=$(awk -F "|" '
    NR > 1 {
        gsub(/^\s+|\s+$/, "", $3);
        print $3
    }' "$1" | sort | uniq -c | sort -k1,1nr -k2 | head -n 3)

if [ $? -ne 0 ]; then
    echo "Ошибка при обработке файла."
    exit 1
fi

echo "$top_3"
