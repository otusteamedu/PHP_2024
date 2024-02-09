#! /bin/bash
if ! [[ "$1" =~ ^[-+]?[0-9]*$ || "$1" =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]
then
  echo "error: first argument must be number"
  exit 2
fi
if ! [[ "$2" =~ ^[-+]?[0-9]*$ || "$2" =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]
then
  echo "error: second argument must be number"
  exit 2
fi
sum=$(awk "BEGIN {print $1+$2; exit}")
echo $sum