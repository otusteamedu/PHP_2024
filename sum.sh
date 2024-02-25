#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo "Ошибка: требуется ровно два аргумента."
    exit 2
fi

regex='^-?[0-9]+(\.[0-9]+)?$'

if ! [[ $1 =~ $regex ]] || ! [[ $2 =~ $regex ]]; then
    echo "Ошибка: оба аргумента должны быть числами."
    exit 2
fi

sum=$(awk -v a="$1" -v b="$2" 'BEGIN { print a + b }')

echo $sum
