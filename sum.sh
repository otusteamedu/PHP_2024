#!/bin/bash

if [ "$#" -ne 2 ]
then
  echo "Введите 2 аргумента!"
  exit 1
fi
regExp='^[-]?[0-9]+\.?[0-9]*$'
if ! [[ "$1" =~ $regExp ]] || ! [[ "$2" =~ $regExp ]]
then
  echo "Оба аргумента должны быть числами!"
  exit 1
fi
echo "Сумма двух чисел:"
echo "$1 $2" | LC_NUMERIC="en_US.UTF-8" awk '{print $1 + $2}'