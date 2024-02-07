#!/bin/env bash

if ! [[ "$1" =~ ^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)+$ ]]; then
  echo ERROR: $1 is not a number
  exit 1
fi

if ! [[ "$2" =~ ^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)+$ ]]; then
  echo ERROR: $2 is not a number
  exit 1
fi

sum=$(awk "BEGIN {print $1+$2; exit}")

echo $sum
