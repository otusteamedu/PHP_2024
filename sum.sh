#! /usr/bin/env bash
clear

if [[ $# -ne 2 ]]
then
echo "Invalid number of arguments"
exit 1
fi

function isNumeric {
echo $(echo $1 | grep -E "^[+-]?[0-9]+[.,]?[0-9]*$")
}

if [[ $(isNumeric $1) == "" || $(isNumeric $2) == "" ]]
then
echo "Invalid arguments"
exit 1
fi

function normalize {
echo $(echo $1 | sed 's/,/./g')
}

operand1=$(normalize $1)
operand2=$(normalize $2)

echo $(echo $1 $2 | awk "{print ${operand1}+${operand2}}")

exit 0

