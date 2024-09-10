#!/bin/bash

sum=0

for arg in "$@"
do
  if [[ $arg =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
      sum=$(awk "BEGIN {print $sum + $arg}")
    else
      echo "Notice: '$arg' is not a number."
    fi
done

echo "Сумма: $sum"
