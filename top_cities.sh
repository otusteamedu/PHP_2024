#!/bin/bash

for cmd in awk sort uniq head; do
  if ! command -v "$cmd" &> /dev/null; then
    echo "Утилита $cmd не установлена. Пожалуйста, установите её и повторите попытку."
    exit 1
  fi
done

if [ "$#" -ne 1 ]; then
  echo "Использование: $0 <имя_файла>"
  exit 1
fi

filename=$1

if [ ! -f "$filename" ]; then
  echo "Файл '$filename' не найден!"
  exit 1
fi

echo "Топ-3 наиболее популярных городов:"

awk 'NR>1 {print $3}' "$filename" | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2 ": " $1 " пользователей"}'
