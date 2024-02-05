#!/bin/bash

regExp='^[-]?[0-9]+\.?[0-9]*$'

if [[ $1 =~ $regExp && $2 =~ $regExp ]]
then
    awk "BEGIN{ print $1 + $2 }"
else
    echo "Для суммирования принимаются только числа!"
fi