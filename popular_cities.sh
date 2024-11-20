#!/bin/bash

FILE="users.txt"

if [ ! -f $FILE ]; then
  echo "Ошибка: Файл $FILE не существует"
  exit 1
fi

POPULAR_CITIES=$(awk 'NR>1 {print $3}' $FILE | sort | uniq -c | sort -rn | head -n 3)

echo "3 наиболее популярных города:"
echo "$POPULAR_CITIES" | awk '{print $2, $1}'