#!/bin/bash

if [ "$#" -lt 2 ]; then
  echo "You should pass at least 2 terms (arguments) for summation."
  exit 1
fi

number_regex='^-?[0-9]+([.][0-9]+)?$'

sum=0

for term in "$@"; do
  if ! [[ $term =~ $number_regex ]]; then
    echo "The argument '$term' is not a valid number."
    exit 1
  fi

  sum=$(echo "$sum + $term" | bc)
done

echo "$sum"
