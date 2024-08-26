#!/bin/bash

if [ $# -ne 1 ]; then
    echo 'Usage: ./cities.sh <filename>';
    exit 1;
fi;

awk 'NR>1 {print $3}' "$1" | sort | uniq -c | sort -nr | head -5 | awk '{print $2 " appears " $1 " times"}'
