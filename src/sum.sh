#!/bin/bash

if [[ $# -ne 2 ]]; then
  echo "В качестве аргументов нужно указать 2 числа!"
  exit 1
fi

function validateNumber() {
    if ! [[ $1 =~ ^[-]?[0-9]+(\.[0-9]+)?$ ]]; then
       echo "$1 не является корректным числом!"
       exit 1
    fi
}

validateNumber $1
validateNumber $2

echo "$1 $2" | awk '{print $1 + $2}'
exit 0