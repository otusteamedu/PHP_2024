#!/bin/bash
function emptyNumber() {
    NUMBER=$1
    if [ -z $NUMBER ]
    then
        return 0
    fi
    return 1
}

function isValidNumber() {
    NUMBER_EXPRESSION='^[+-]?[0-9]+([.][0-9]+)?$'
    NUMBER=$1
    
    if ! [[ $NUMBER =~ $NUMBER_EXPRESSION ]] ;
    then
        return 0
    fi
    return 1
}


NUM1=$1
NUM2=$2


if emptyNumber $NUM1
then
    echo "Error: First argument is empty! Exitting!"
    exit -1
elif isValidNumber $NUM1
then
    echo "Error: First argument is not valid number! Exitting!"
    exit -2
elif emptyNumber $NUM2
then
    echo "Error: Second argument is empty! Exitting!"
    exit -1
elif isValidNumber $NUM2
then
    echo "Error: Second argument is not valid number! Exitting!"
    exit -2
fi

SUM=$(awk "BEGIN {print $NUM1+$NUM2; exit}")

echo "Sum is: $SUM"