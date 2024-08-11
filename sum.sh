#!/bin/bash

if [ $# -gt 2 ] || [ $# -lt 2 ]; then
    echo "Скрипт работает только с двумя аргументами"
    exit 1
fi

regexp='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $regexp ]] || ! [[ $1 =~ $regexp ]]; then
    echo "Аргументы не являются числом"
    exit 1
fi


sum=$(awk "BEGIN {print $1 + $2}")

echo Сумма: $sum
