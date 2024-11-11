#!/usr/bin/env bash

if [ "$#" -ne 2 ]; then
  echo "Ошибка: требуется два аргумента"
  exit 1
fi

numReg="^-?[0-9]+([.][0-9]+)?$"

if ! [[ $1 =~ $numReg && $2 =~ $numReg ]]; then
  echo "Введите корректные числа"
  exit 1
fi


result=$(awk "BEGIN {print $1 + $2}")

echo "Результат сложения $1 + $2 = $result"
