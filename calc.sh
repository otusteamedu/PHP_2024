#! /bin/bash

if [ -z "$1" ] || [ -z "$2" ]
then
	echo "Add 2 params to your script"
	exit 1
fi

REG="^[+-]?[0-9]+([.][0-9])?$"

if ! [[ "$1" =~ $REG  ]] || ! [[ "$2" =~ $REG  ]]
then
	echo "Enter numbers"
	exit 1
fi

SUMM=$(awk "BEGIN {print $1 + $2}")

echo "$1 + $2 = $SUMM"
