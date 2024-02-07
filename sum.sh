#!/bin/bash

FIRST_SUMMAND=$1
SECOND_SUMMAND=$2

if [ -z $FIRST_SUMMAND ]
then
    echo "First summand is empty! Exitting!"
    exit -1
fi

NUMBER_EXPRESSION='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $FIRST_SUMMAND =~ $NUMBER_EXPRESSION ]] ;
then
    echo "First summand is not a number! Exitting!"
    exit -1
fi

if [ -z $SECOND_SUMMAND ]
then
    echo "Second summand is empty! Exitting!"
    exit -1
fi

if ! [[ $SECOND_SUMMAND =~ $NUMBER_EXPRESSION ]] ;
then
    echo "Second summand is not a number! Exitting!"
    exit -1
fi

SUMMA=$(awk "BEGIN {print $FIRST_SUMMAND+$SECOND_SUMMAND; exit}")

echo "Sum is: $SUMMA"
