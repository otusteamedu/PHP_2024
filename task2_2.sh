#!/bin/bash

FILE="table.txt"

if [ ! -f $FILE ]; then
    echo "File $FILE not found!"
fi

awk '{print $3}' $FILE | tail -n +2 | sort | uniq -c | sort -nr | head -n3 | awk '{print $2}'

