#!/bin/bash

# Проверка наличия аргумента (имени файла)
if [[ $# -ne 1 ]]; then
    echo "Usage: $0 <filename>"
    exit 1
fi

# Проверка существования файла
if [[ ! -f $1 ]]; then
    echo "File not found!"
    exit 1
fi

# Обработка файла и вывод 3 наиболее популярных городов
awk 'NR > 1 && $3 != "" {print $3}' "$1" | sort | uniq -c | sort -nr | head -n 3