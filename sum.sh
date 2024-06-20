#!/bin/bash

term_1=$1
term_2=$2

if [ "$#" -ne 2 ]; then
  echo "You should pass 2 terms (arguments) for summation."
  exit 1
fi

number_regex='^-?[0-9]+([.][0-9]+)?$'

if ! [[ $term_1 =~ $number_regex ]]; then
  echo "The first argument is not a valid number."
  exit 1
fi

if ! [[ $term_2 =~ $number_regex ]]; then
  echo "The second argument is not a valid number."
  exit 1
fi

echo "$term_1 + $term_2" | bc
