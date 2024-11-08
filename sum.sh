#!/bin/bash

is_number() {
    [[ $1 =~ ^-?[0-9]+\.?[0-9]*$ ]]
}


if { is_number "$1" && is_number "$2" ; }
then
	result=$(awk "BEGIN {printf \"%.2f\", $1 + $2}")
	echo "Сумма чисел $1 + $2 = $result"
else
	echo "Error arguments!"
fi

exit 0
