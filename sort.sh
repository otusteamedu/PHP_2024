#!/bin/bash

# Программа, которая выводит на экран 3 наиболее популярных
# города из файла city.txt

if [ "$#" -ne 1 ]
then
  echo 'Нужно ввести имя файла с расширением'
  exit 1
fi

awk 'NF > 0 && $3 != "city" {print $3}' $1 |  tail -n +1 | sort | uniq -c | sort -r | head -3 | awk '{print $2}'
