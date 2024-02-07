#!/bin/bash

if [[ "$1" =~ ^[0-9]+$ || "$1" =~ ^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)+$ ]]; then
  first=$1
else
  echo ERROR: $1 is not a number
  exit 1
fi

if [[ "$2" =~ ^[0-9]+$ || "$2" =~ ^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)+$ ]]; then
  second=$2
else
  echo ERROR: $2 is not a number
  exit 1
fi

sum=$(awk "BEGIN {print $first+$second; exit}")

echo $sum
