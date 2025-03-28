#!/bin/bash

# Программа, которая суммирует два числа

x=$1
y=$2
pattern='^[+-]?[0-9]+([.][0-9]+)?$'

if [ "$#" -ne 2 ]
then
  echo 'Введите 2 параметра'
  exit 1
fi

if ! [[ "$x" =~ $pattern ]];
then
  echo 'Первый параметр должен быть числом'
  exit 1
fi

if ! [[ "$y" =~ $pattern ]];
then
  echo 'Второй параметр должен быть числом'
  exit 1
fi

echo $(awk "BEGIN {print $x + $y}")
