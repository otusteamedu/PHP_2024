#!/bin/bash

re='^[+-]?[0-9]+([.][0-9]+)?$'

if which bc > /dev/null
then
    ! [[ $1 =~ $re ]] && echo "Firt argument is not integer" && exit 1;
    ! [[ $2 =~ $re ]] && echo "Second argument is not integer" && exit 1;

    echo "$1 + $2" | bc
else
    echo "bc package is not isntalled"
fi
