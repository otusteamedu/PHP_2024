#!/bin/bash

# Проверка на наличие хотя бы 2-х аргументов
if [ $# -lt 2 ]; then
  echo "Ошибка: Необходимо передать 2 числа в качестве аргументов."
  exit 1
fi

# Проверка, являются ли первые 2 переданных аргумента числом (с использованием регулярного выражения)
for arg in $1 $2; do
  if ! [[ "$arg" =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
    echo "Ошибка: Аргумент $arg не является корректным числом"
    exit 1
  fi
done

# Функция для вычисления суммы
calculate_sum() {
  if command -v bc &> /dev/null; then
    sum=$(echo "$1 + $2" | bc)
  elif command -v awk &> /dev/null; then
    sum=$(awk "BEGIN {print $1 + $2}")
  elif command -v dc &> /dev/null; then
    sum=$(echo "$1 $2 + p" | dc)
  else
    echo "Ошибка: Необходимо установить один из пакетов 'bc', 'awk' или 'dc' для выполнения расчетов."
    exit 1
  fi
  echo "Результат сложения: $sum"
}

# Вызов функции для вычисления суммы
calculate_sum "$1" "$2"
