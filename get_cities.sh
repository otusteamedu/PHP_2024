#!/bin/bash

FILE='cities.txt'

if ! [[ -f $FILE ]]; then
  echo "Файл $FILE не найден."
  exit 1
fi

echo 'Три наиболее популярных города среди пользователей:'
awk '{print $3}' $FILE | tail -n +2 | sort | uniq -c | sort -rn | head -n3 | awk '{print $2}'
