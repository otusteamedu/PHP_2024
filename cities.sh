#!/bin/bash

# Проверка, что файл передан как аргумент
if [ $# -lt 1 ]; then
    echo "Ошибка: укажите файл с таблицей."
    exit 1
fi

FILE=$1

# Проверка, что файл существует
if [ ! -f "$FILE" ]; then
    echo "Ошибка: файл $FILE не найден."
    exit 1
fi

# Анализ таблицы и вывод 3 самых популярных городов
awk 'NR > 1 {print $3}' "$FILE" | sort | uniq -c | sort -nr | head -n 3
