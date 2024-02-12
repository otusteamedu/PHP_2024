#!/bin/bash

if [[ $# -ne 2 ]]; then
  echo "В качестве аргументов нужно указать 2 числа!"
  exit 1
fi

numberPattern="^[-]?[0-9]+(\.[0-9]+)?$"

if ! [[ $1 =~ $numberPattern ]]; then
   echo "$1 не является корректным числом!"
   exit 1
fi

if ! [[ $2 =~ $numberPattern ]]; then
   echo "$2 не является корректным числом!"
   exit 1
fi

echo "$1 $2" | awk '{print $1 + $2}'
exit 0