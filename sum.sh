#!/bin/bash

FST=$1
SCD=$2

function IsEmpty() {
    NUMBER=$1
    if [ -z $NUMBER ]
    then
        return 0
    fi
    return 1
}

function IsAllowable() {
    NUMBER_EXPRESSION='^[+-]?[0-9]+([.][0-9]+)?$'
    NUMBER=$1
    if ! [[ $FST =~ $NUMBER_EXPRESSION ]] ;
    then
        return 1
    fi
    return 0
}



if  IsEmpty $FST || IsEmpty $SCD
then
    echo "Нужно два аргумента!"
    exit -1
elif ! IsAllowable $FST
then
    echo "Ошибка в первом слогаемом!"
    exit -2
elif ! IsAllowable $SCD
then
    echo "Ошибка во втором слогаемом!"
    exit -2
fi

SUMM=$(awk "BEGIN {printf $FST+$SCD; exit}")

echo $SUMM
