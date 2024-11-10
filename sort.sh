#!/bin/bash

FILE=$1

if [ "$#" -ne 1 ]; then
  echo "Использование: $0 <имя_файла>"
  exit
fi

if [ ! -f "$FILE" ]; then
  echo "Файл не существует"
  exit
fi

awk '{print $3}' "$FILE" | sort | head -n 5 | uniq -c | sort -nr | head -n 3