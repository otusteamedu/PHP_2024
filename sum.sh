#!/bin/bash

for cmd in bc; do
  if ! command -v "$cmd" &> /dev/null; then
    echo "Утилита $cmd не установлена. Пожалуйста, установите её и повторите попытку."
    exit 1
  fi
done

if [ "$#" -ne 2 ]; then
    echo "Ошибка: Требуется ровно два числовых аргумента."
    exit 1
fi

regex='^-?[0-9]+(\.[0-9]+)?$'

if [[ ! $1 =~ $regex ]]; then
    echo "Ошибка: '$1' не является допустимым числом."
    exit 1
fi

if [[ ! $2 =~ $regex ]]; then
    echo "Ошибка: '$2' не является допустимым числом."
    exit 1
fi

sum=$(echo "$1 + $2" | bc)

echo "Сумма: $sum"
