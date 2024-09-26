#!/bin/bash

FILE=$1

if [ -f $FILE ]; then
    awk 'NR > 1 {print $3}' $FILE | sort | uniq -c | sort -rk1 | head -3
else
    echo -e '\e[1;31m File does not exist \e[0m' >&2; exit 1
fi