#!/bin/bash

if (($# < 1))
then
    echo "Передайте путь к файлу"
    exit 1
fi

awk 'NR > 1 && $3 != "" {print $3}' $1 | sort | uniq -c | sort -nr | head -n 3
