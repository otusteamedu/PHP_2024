#!/bin/bash

# Проверка наличия утилиты bc
if ! command -v bc &> /dev/null; then
  echo "Ошибка: утилита 'bc' не установлена. Пожалуйста, установите её с помощью 'sudo apt install bc' (для Ubuntu/Debian)."
  exit 1
fi

# Проверка, что переданы два аргумента
if [ $# -ne 2 ]; then
  echo "Ошибка: необходимо указать два аргумента"
  exit 1
fi

# Регулярное выражение для проверки числа (поддерживает целые и дробные числа)
number_regex='^-?[0-9]+([.][0-9]+)?$'

# Проверка первого аргумента
if [[ ! $1 =~ $number_regex ]]; then
  echo "Ошибка: первый аргумент '$1' не является числом"
  exit 1
fi

# Проверка второго аргумента
if [[ ! $2 =~ $number_regex ]]; then
  echo "Ошибка: второй аргумент '$2' не является числом"
  exit 1
fi

# Вычисление суммы
sum=$(echo "$1 + $2" | bc)

# Вывод суммы
echo "Сумма: $sum"
