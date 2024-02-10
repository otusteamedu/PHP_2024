#!/bin/bash

echo "Calculator is starting..."
if [ "$#" -ne 2 ]
then
  echo "You must enter 2 arguments!"
  exit 1
fi
regExp='^[-]?[0-9]+\.?[0-9]*$'
if ! [[ "$1" =~ $regExp ]] || ! [[ "$2" =~ $regExp ]]
then
  echo "Both arguments must be numbers!"
  exit 1
fi
echo "The sum of two numbers:"
echo "$1 $2" | LC_NUMERIC="en_US.UTF-8" awk '{print $1 + $2}'
