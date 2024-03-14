#!/bin/bash

if [ "$#" -ne 1 ]
then
  echo "Введите имя файла со списком городов как аргумент!"
  exit 1
fi
if ! [[ -f "$1" ]]
then
  echo "Нет такого файла!"
  exit 1
fi
headerPattern='id user city phone'
header=$(head -1 $1)
if ! [ "$header" = "$headerPattern" ]
then
  echo "Файл не подходящего формата!"
  exit 1
fi
echo "Самые популярные города:"
awk 'length { print $3 }' $1 | tail -n +2 | sort | uniq -c | sort -rnk1 | awk '{ print $2 }' | head -3