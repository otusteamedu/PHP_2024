#!/usr/bin/bash

if [ "$#" -eq 2 ]
then
    if [[ "$1" =~ ^-?[0-9]+[.]?[0-9]*$ && "$2" =~ ^-?[0-9]+[.]?[0-9]*$ ]]
    then
        if [[ "$1" =~ .\. || "$2" =~ .\. ]]
        then 
            result=$(awk "BEGIN {printf \"%.2f\", ${1}+${2}}")
            echo "$result" | sed 's/\,/\./'
        else
            let result=$1+$2
            echo "$result"
        fi
    else
        echo "One of args is not a number"
    fi
else
    echo "Args less or more than 2"
fi