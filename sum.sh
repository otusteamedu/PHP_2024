#!/bin/bash

if (($# < 2))
then
    echo "Нужно передать 2 параметра для сложения"
    exit 1
fi

REGEX="^[+-]?[0-9]+([.][0-9]+)?$"

if [[ ! $1 =~ $REGEX ]];
    then echo "Ошибка: $1 Не число" >&2; exit 1
fi

if [[ ! $2 =~ $REGEX ]];
    then echo "Ошибка: $2 Не число" >&2; exit 1
fi

echo "$1 + $2 =" $(awk "BEGIN {print $1+$2; exit}")
