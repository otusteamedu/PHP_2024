#!/bin/bash

if [ "${#}" -le 1 ]; then
    echo "Недостаточно аргументов. Пожалуйста, передайте в качестве аргументов два числа."
    exit 1
fi

printf '%f' "${1}" >/dev/null 2>&1
if [ "$?" -ne 0 ]; then
    echo "Первый аргумент не является числом"
    exit 1
fi
printf '%f' "${2}" >/dev/null 2>&1
if [ "$?" -ne 0 ]; then
    echo "Второй аргумент не является числом"
    exit 1
fi
echo "$1" "$2" | awk '{print $1+$2}'