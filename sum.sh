#!/bin/bash

if [ $# -ne 2 ]; then
    echo "Ошибка: Необходимо 2 аргумента"
    exit 1
fi

REGEXP='^[-]?[0-9]+(\.[0-9]+)?$'

if ! [[ $1 =~ $REGEXP ]] || ! [[ $2 =~ $REGEXP ]]; then
    echo "Ошибка: Оба аргумента должны быть числами"
    exit 1
fi

SUM=$(awk "BEGIN {print $1 + $2}")
echo "Сумма $1 и $2 равна $SUM"
