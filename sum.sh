#!/bin/bash

firstArg=$1
secondArg=$2

if [ -z "$firstArg" ] || [ -z "$secondArg" ]; then
    echo "Необходимо передать два аргумента"
    exit 1
fi

for var in $firstArg $secondArg
do
  if ! [[ $var =~ ^[+-]?[0-9]+\.?[0-9]?+$ ]]; then
      echo "$var не является числом." >&2
      exit 1
  fi
done

res=$(echo $firstArg+$secondArg | bc)

echo $res
