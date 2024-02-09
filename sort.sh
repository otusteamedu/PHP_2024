#!/bin/bash

FILE="city.txt"

if [ ! -f $FILE ]; then
  echo "Ошибка: Файл $FILE не существует"
  exit 1
fi

CITIES=$(awk 'NR>1 {print $3}' $FILE | sort | uniq -c | sort -rn | head -n 3)

echo "$CITIES" | awk '{print $2, $1}'
