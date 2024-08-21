#!/bin/bash

regexp='^[+-]?[0-9]+([.][0-9]+)?$'
message="Программа принимает только два аргумента"

if [ $# -eq 2 ]; then
  message="Аргументы должны быть числом"

  if [[ ($1 =~ $regexp) && ($2 =~ $regexp) ]]; then
    message="Сумма аргументов: $(awk "BEGIN {printf $1+$2; exit}")"
  fi
fi

echo $message
