#!/usr/bin/env bash

if [ "$#" -ne 2 ]
  then
    echo "There are exactly two arguments required"
    exit 1
fi

NUMBER_1=$1
NUMBER_2=$2
NUMBER_REGEXP="^[-]?[0-9]+([.][0-9]+)?$"

for i in $NUMBER_1 $NUMBER_2
do
  if ! [[ $i =~ $NUMBER_REGEXP ]]
    then
      echo "Error: '${i}' is not a number"
      exit 1
  fi
done

SUM=$(echo "$NUMBER_1" "$NUMBER_2" | awk '{print $1 + $2}')

echo "Sum is: ${SUM}"
