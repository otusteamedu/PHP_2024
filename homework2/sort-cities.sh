#!/bin/bash
FILE_NAME=cities

if [ ! -f $FILE_NAME ]
  then
    echo 'Отстутствует файл с городами'
    exit 1;
fi

# Пропуск первой строки -> сортировка по Городам -> поиск уникальных городов с их количеством
# -> обратная сортировка по кол-ву городов -> вывод первых 3
echo $(awk 'NR>1 {print $3}' $FILE_NAME | sort | uniq -c | sort -r | head -n 3)