#!/bin/bash

if [ "$#" -ne 1 ]; then
    echo 'Invalid number of arguments'
    exit -1
fi

awk 'NF > 0 && $3 != "city" {print $3}' $1 | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2}'
exit 0