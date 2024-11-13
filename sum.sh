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

result=$(echo "$1 + $2" | bc)
echo "Результат: $result"