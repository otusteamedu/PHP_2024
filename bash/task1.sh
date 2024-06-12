#!/bin/sh

if [ $# -ne 2 ]; then
  echo "Usage: $0 num1 num2"
  exit 1
fi

is_number() {
  [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
}

if ! is_number "$1" || ! is_number "$2"; then
  echo "Both arguments must be numbers."
  exit 1
fi

num1=$1
num2=$2

sum=$(awk "BEGIN {print $num1 + $num2}")

echo "The sum is: $sum"