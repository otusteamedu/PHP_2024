#!/usr/bin/bash

if [ "$#" -eq 2 ]
then
    if [[ "$1" =~ ^-?[0-9]+[.]?[0-9]*$ && "$2" =~ ^-?[0-9]+[.]?[0-9]*$ ]]
    then
        result=$(awk "BEGIN {print ${1}+${2}}")
        echo "$result" | sed 's/\,/\./'
    else
        echo "One of args is not a number"
    fi
else
    echo "Args less or more than 2"
fi