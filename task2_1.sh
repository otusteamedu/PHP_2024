#!/bin/bash

CNT_ARG=2

if [ $# -ne $CNT_ARG ]
then
    echo "Error! Need $CNT_ARG arguments, example ./task2_1.sh 1.5 -7"
    exit
fi

regex="^(-)?[0-9]+(\.[0-9]+)?$";

for arg in "${@}" 
do
    if ! [[ "$arg" =~ $regex ]];
    then 
        echo "Error! $arg not number"
        exit
    fi
done

TOTAL=0

for arg in "${@}" 
do
    TOTAL=$(echo | awk "{print $arg+$TOTAL}")
done

echo $TOTAL
