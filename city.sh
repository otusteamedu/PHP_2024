#!/bin/bash

file_name="city.txt"

if [ ! -f $file_name ]; then
    echo "Файл не найден"
    exit 1
fi

awk 'NR>1 {print $3}' $file_name | sort | uniq -c | sort -r | head -n 3
