#!/bin/bash

if [ "$#" -eq 2 ]; then
    REG_EXP_PATTERN='^[+-]?[0-9]+([.][0-9]+)?$'

    if ! [[ "$1" =~ $REG_EXP_PATTERN ]]; then
        echo 'First argument is not a number'
        exit -1
    fi

    if ! [[ "$2" =~ $REG_EXP_PATTERN ]]; then
        echo 'Second argument is not a number'
        exit -1
    fi

    echo $(awk "BEGIN {print $1 + $2}")
    exit 0
else
    echo 'Amount of arguments does not match'
    exit -1
fi