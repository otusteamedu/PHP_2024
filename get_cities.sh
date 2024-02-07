#!/bin/bash

FILE='cities.txt'

if ! [[ -f $FILE ]]; then
  echo "Файл по умолчанию '$FILE' не найден в директории '$PWD'"
  read -p "Введите название файла с городами: " USER_FILE
  if ! [[ -f $USER_FILE ]]; then
    echo "Файл '$USER_FILE' не найден в директории '$PWD'"
    exit 1
  fi
  FILE=$USER_FILE
fi

echo "Анализ файла '$FILE' завершён. Три наиболее популярных города среди пользователей:"
awk '{print $3}' $FILE | tail -n +2 | sort | uniq -c | sort -rn | head -n3 | awk '{print $2}'
