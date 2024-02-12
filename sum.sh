#!/bin/bash

requiredArgsCount=2

if [ "$requiredArgsCount" -ne "$#" ]; then
  echo "Передано неверное количество аргументов, необходимо передать $requiredArgsCount аргумента"
  exit 1
fi

argNum=1
sum=0

for arg in "$@"; do
  if ! [[ "$arg" =~ ^[0-9.+-]+$ ]]; then
    echo "Не верное значение $argNum-го аргумента. Доступны только числовые значения. Пример: 1, -1, 1.65, -3.56"
    exit 1
  fi

  argNum=$(( argNum + 1 ))
  sum=$(awk "BEGIN { sum = $sum + $arg; print sum }" | tr ',' '.')
done

echo "Сумма: $sum"