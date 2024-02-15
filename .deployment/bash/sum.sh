#!/bin/bash

PARAM_COUNT=$#
if [ $PARAM_COUNT -lt 2 ]; then
    echo 'Для операции необходимо передать два числа!'
    exit 1
fi

NUM1=$1
NUM2=$2

RES=$(echo "scale=2; $NUM1 + $NUM2" | bc -l )
# ToDo: Учесть что при аргументах -2.2 2 получается -.2
if [[ $RES == .* ]]; then
    RES="0$RES"
fi

echo $RES

