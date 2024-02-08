#!/bin/bash

FILE='cities.txt'

if ! [[ -f $FILE ]]; then
  echo "Файл по умолчанию '$FILE' не найден в директории '$PWD'"
  while ! [[ -f $USER_FILE ]]; do
    read -p "Введите название файла с городами: " USER_FILE
    if ! [[ -f $USER_FILE ]]; then
      echo -e "Файл '$USER_FILE' не найден в директории '$PWD'.\nВведите название файла повторно или нажмите <CTRL+C> для выхода."
    fi
  done
  FILE=$USER_FILE
fi

echo "Анализ файла '$FILE' завершён. Три наиболее популярных города среди пользователей:"
awk '{print $3}' $FILE | tail -n +2 | sort | uniq -c | sort -rn | head -n3 | awk '{print $2}'
