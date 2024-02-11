#!/bin/bash

if [ $# -ne 2 ]; then
    echo "incorrect number of arguments"
    exit 1
fi

if [[ $1 =~ ^-?[0-9]+[.]?[0-9]*$ && $2 =~ ^-?[0-9]+[.]?[0-9]*$ ]]
then
    RES=$(awk "BEGIN {print ${1}+${2}}")
    echo $RES | sed 's/\,/\./'
    exit 0
else
    echo "One of args is not a number"
fi