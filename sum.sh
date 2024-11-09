#!/usr/bin/env bash

if ! command -v bc >/dev/null 2>&1; then
  echo "Команда 'bc' не установлена. Попытка установки..."

  #ubuntu
  if command -v apt >/dev/null 2>&1; then
    sudo apt update && sudo apt install -y bc
  fi
fi

if [ "$#" -ne 2 ]; then
  echo "Ошибка: требуется два аргумента"
  exit 1
fi

numReg="^-?[0-9]+([.][0-9]+)?$"

if ! [[ $1 =~ $numReg && $2 =~ $numReg ]]; then
  echo "Введите корректные числа"
  exit 1
fi


result=$(echo "$1 + $2" | bc)

echo "Результат сложения $1 + $2 = $result"
