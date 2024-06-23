#!/bin/bash
REGEX="^[-+]?[0-9]+(\.[0-9]+)?$"
FIRST_NUMBER=$1
SECOND_NUMBER=$2
if [[ ! $FIRST_NUMBER =~ $REGEX ]];
    then
      echo "Первый аргумент не является числом";
      exit 1
fi
if [[ ! $SECOND_NUMBER =~ $REGEX ]];
    then
      echo "Второй аргумент не является числом";
      exit 1
fi
SUM=$FIRST_NUMBER+$SECOND_NUMBER
awk "BEGIN {print $SUM}"