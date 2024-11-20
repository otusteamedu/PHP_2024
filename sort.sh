#!/bin/bash

# Файл с данными городов
file=./data.txt

# Проверка существования файла
if [ ! -e "$file" ]; then
    echo "Файл с данными не существует!"
    exit 1
fi

# Вывод трёх наиболее популярных города среди пользователей системы
cat "$file" | grep -Ev '^([[:space:]]|[[:alpha:]])+' |  awk '{print $3}' | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2}'