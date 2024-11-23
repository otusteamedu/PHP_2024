#!/bin/bash

# Проверка наличия файла с данными
if [ ! -f "data.txt" ]; then
    echo "Ошибка: Файл data.txt не найден."
    exit 1
fi

# Извлечение столбца с городами и подсчет частоты встречаемости
awk '{print $3}' data.txt | sort | uniq -c | sort -nr | head -n 3