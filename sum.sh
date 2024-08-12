#!/bin/bash

re='^[+-]?[0-9]+([.][0-9]+)?$'

! [[ $1 =~ $re ]] && echo "Firt argument is not integer" && exit 1;
! [[ $2 =~ $re ]] && echo "Second argument is not integer" && exit 1;

echo $(awk "BEGIN {printf $1 + $2}")