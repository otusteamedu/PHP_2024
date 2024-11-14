#!/bin/bash

is_number() {
    [[ $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
}

if [ "$#" -ne 2 ]; then
    echo "Ошибка: скрипт требует два числовых аргумента"
    exit 1
fi

for arg in "$@"; do
    if ! is_number "$arg"; then
        echo "Ошибка: '$arg' не является числом"
        exit 1
    fi
done

sum() {
    local num1=$1
    local num2=$2
    echo "$(awk "BEGIN {print $num1 + $num2}")"
}

result=$(sum "$1" "$2")
echo "Результат: $result"