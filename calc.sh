#!/bin/bash
REGEX="^[-+]?[0-9]+[\.|\,]?[0-9]*$"
for arg in $@
do
    if [[ ! $arg =~ $REGEX ]];
    then
        echo "Argument $arg is not a number"
        exit
    fi
done
FIRST_ARG=$1
SECOND_ARG=$2
FIRST_ARG=$(sed -e "s/[,]/./g" <<< $FIRST_ARG)
SECOND_ARG=$(sed -e "s/[,]/./g" <<< $SECOND_ARG)
if ! command -v bc &> /dev/null
then
    TOTAL=$(awk "BEGIN {print $FIRST_ARG + $SECOND_ARG;}") 
else
    TOTAL=$(bc <<< $FIRST_ARG+$SECOND_ARG)
fi
echo $TOTAL
