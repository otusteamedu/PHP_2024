#!/bin/bash
ARG1=$1
ARG2=$2

if ! command -v bc &>/dev/null; then
    echo "'bc' could not be found"
    echo "Please, install 'bc' package"
    exit 1
fi

checkNumber() {
    if ! [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
        echo "'${1}' is not number"
        exit 1
    fi
}

checkNumber $ARG1
checkNumber $ARG2

SUM=$(echo "${ARG1} + ${ARG2}" | bc)

echo $SUM
