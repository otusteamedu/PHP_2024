#!/bin/bash

FIRST_ARGUMENT=$1
SECOND_ARGUMENT=$2

if [ $# -ne 2 ]
then
    echo "Error: The script expects two arguments."
    exit 1
fi

is_number()
{
    if [[ $1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
    then
        return 0
    else
        return 1
    fi
}

if ! is_number "$FIRST_ARGUMENT"
then
    echo "Error: The first argument '$FIRST_ARGUMENT' is not a number."
    exit 1
fi

if ! is_number "$SECOND_ARGUMENT"
then
    echo "Error: The second argument '$SECOND_ARGUMENT' is not a number."
    exit 1
fi

SUM=$(awk -v first="$FIRST_ARGUMENT" -v second="$SECOND_ARGUMENT" 'BEGIN {print first + second}')

echo "Sum: $SUM"