#!/bin/bash

regex='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $regex ]]
then
  echo "Первый аргумент отсутствует или не является числом"
  exit 1
fi

if ! [[ $2 =~ $regex ]]
then
  echo "Второй аргумент отсутствует или не является числом"
  exit 1
fi

sum=$(awk "BEGIN {printf $1+$2; exit}")

echo $sum
