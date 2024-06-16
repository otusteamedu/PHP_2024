#!/bin/bash

NUMBERS_REGEX="^-?[0-9]*([.][0-9]*)?$"

if ! [[ $1 =~ $NUMBERS_REGEX ]] || ! [[ $2 =~ $NUMBERS_REGEX ]];
then
    echo "Invalid arguments"
    exit 1;
fi
awk "BEGIN{ print $1 + $2 }"
