#!/bin/bash

first_num=$1
second_num=$2
re_number='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $first_num =~ $re_number && $second_num =~ $re_number ]];
then
  echo 'Введите два числа'; exit 1;
fi

sum=$(awk "BEGIN {print $first_num+$second_num; exit}")

echo "Сумма чисел $first_num и $second_num равна $sum"