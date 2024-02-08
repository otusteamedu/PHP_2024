#!/bin/bash

FIRST_SUMMAND=$1
SECOND_SUMMAND=$2

function emptyNumber() {
    NUMBER=$1
    if [ -z $NUMBER ]
    then
        return 0
    fi
    return 1
}

function notAllowableNumber() {
    NUMBER_EXPRESSION='^[+-]?[0-9]+([.][0-9]+)?$'
    NUMBER=$1
    if ! [[ $FIRST_SUMMAND =~ $NUMBER_EXPRESSION ]] ;
    then
        return 0
    fi
    return 1
}

if emptyNumber $FIRST_SUMMAND
then
    echo "First summand is empty! Exitting!"
    exit -1
elif notAllowableNumber $FIRST_SUMMAND
then
    echo "First summand is not a number! Exitting!"
    exit -2
elif emptyNumber $SECOND_SUMMAND
then
    echo "First summand is empty! Exitting!"
    exit -1
elif notAllowableNumber $SECOND_SUMMAND
then
    echo "First summand is not a number! Exitting!"
    exit -2
fi

SUMMA=$(awk "BEGIN {print $FIRST_SUMMAND+$SECOND_SUMMAND; exit}")

echo "Sum is: $SUMMA"
