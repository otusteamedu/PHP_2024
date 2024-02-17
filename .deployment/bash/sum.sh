#!/bin/bash

PARAM_COUNT=$#

# Проверяем, установлен ли bc
if ! command -v bc > /dev/null; then
    echo "Для работы этого скрипта требуется пакет 'bc', который не найден в системе."
    echo "Пожалуйста, установите 'bc' с помощью менеджера пакетов вашей системы."
    exit 1
fi

is_float() {
  if [[ $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
        return 0
      else
        return 1
  fi
}

if [ $PARAM_COUNT -lt 2 ]; then
    echo 'Для операции необходимо передать два числа!'
    exit 1
fi

NUM1=$1
NUM2=$2

if ! is_float "$NUM1" || ! is_float "$NUM2"; then
    echo 'Аргументы должны быть числами!'
    exit 1
fi

RES=$(echo "scale=2; $NUM1 + $NUM2" | bc -l )

if [[ $RES == .* ]]; then
    RES="0$RES"
elif [[ $RES == '-.'* ]]; then
    RES="-0.${RES:2}"
fi

echo $RES

