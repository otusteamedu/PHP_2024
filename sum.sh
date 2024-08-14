#!/bin/bash
ARG1=$1
ARG2=$2

if ! command -v bc &> /dev/null
then
    echo "'bc' could not be found"
    echo "Please, install 'bc' package"
    exit 1
fi

if ! [[ $ARG1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
    echo "'${ARG1}' is not number"
    exit 1
fi

if ! [[ $ARG2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
    echo "'${ARG2}' is not number"
    exit 1
fi

SUM=$(echo "${ARG1} + ${ARG2}" | bc)

echo $SUM
