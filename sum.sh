#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Введите ровно два числа!";
    exit 1;
fi;

decimal_sep=$(locale decimal_point);
number_regex="^[-]?[0-9]+([${decimal_sep}][0-9]+)?$"

if ! [[ $1 =~ $number_regex ]]; then
    echo "Первый аргумент - не число!";
    exit 1;
fi;

if ! [[ $2 =~ $number_regex ]]; then
    echo "Второй аргумент - не число!";
    exit 1;
fi;

echo "$1 $2" | awk '{result=$1+$2} END {print  result}';
