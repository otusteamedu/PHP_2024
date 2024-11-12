#!/bin/bash

if ! [[ $# == 2 ]]; then
    echo "Введите правильное количество аргументов";
    exit 1
fi

for var in "$@"
do
    if ! [[ $var =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
      echo "Аргемент $var не число";
      exit 1;
    fi
done

result=$(echo "$1 + $2" | bc)

echo $result