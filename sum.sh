#!/bin/bash
REGEX="^[+-]?[0-9]+([.][0-9]+)?$"
if [[ ! $1 =~ $REGEX ]];
    then echo "Ошибка: Первый аргумент не число"; exit 1
fi
if [[ ! $2 =~ $REGEX ]];
    then echo "Ошибка: Второй аргумент не число"; exit 1
fi
SUM=$(awk "BEGIN {print $1 + $2}")
echo $SUM