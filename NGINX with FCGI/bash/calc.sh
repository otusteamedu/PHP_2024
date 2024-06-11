#!/bin/bash 
A=$1
B=$2
re='^-?[0-9]+[.,]?[0-9]*$'
if ! [[ $A =~ $re ]] || ! [[ $B =~ $re ]]; then
  echo "error: Arguments -  Not a number" >&2; exit 1
fi
apt-get install bc
 C=$(echo $A+$B | bc)
echo $C