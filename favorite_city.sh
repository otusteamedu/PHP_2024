#!/bin/bash

if [ $# -ne 1 ]; then
    echo "Путь к файлу не введен"
    exit 1
fi

if [ ! -f "$1" ]; then
   echo "Файл $1 не существует"
   exit 1
fi

awk '{print $3}' "$1" | tail -n +2 | sort | uniq -ci | sort -r | awk '{print NR,$2}' | head -3
