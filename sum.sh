#!/bin/bash

NUM_1=$1
NUM_2=$2

if [ $# -ne 2 ]; then
    echo 'Invalid number of arguments'
    exit
fi

if ! [[ $NUM_1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]] || ! [[ $NUM_2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
    echo "Some argument not number"
    exit
fi

if ! command -v bc &> /dev/null; then
  echo "Пакет bc не найден. Установка..."
  apt update && apt install -y bc
  if ! command -v bc &> /dev/null; then
    echo "Установка не удалась"
    exit
  else
    echo "Установка завершена успешно"
  fi
fi

echo "$NUM_1 + $NUM_2" | bc
