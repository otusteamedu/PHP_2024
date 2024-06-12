#!/bin/bash

# Файл с данными городов
file=./data.txt

# Проверка существования файла
if [ ! -e "$file" ]; then
    echo "Файл с данными не существует!"
    exit 1
fi

# Чтение данных из файла data.txt
data=$(cat $file)

# Удаление строки заголовков, пустых строк и строк, начинающихся с пробела
data=$(echo "$data" | grep -Ev '^([[:space:]]|[[:alpha:]])+')

# Проверка наличия данных
if [ -z "$data" ]; then
    echo "В файле отсутствуют необходимые данные!"
    exit 1
fi

# Подсчет количества вхождений каждого города
uniq_cities=$(echo "$data" | awk '{print $3}' | sort | uniq -c)

# Сортировка по количеству вхождений в порядке убывания
sorted_cities=$(echo "$uniq_cities" | sort -nr)

# Вывод первых трех строк отсортированного списка
head -n 3 <(echo "$sorted_cities") | awk '{print $2}'