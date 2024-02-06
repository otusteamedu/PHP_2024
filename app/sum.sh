#!/bin/bash

regex='^-?[0-9]+\.?[0-9]*$'
if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]]
then
  awk "BEGIN { print $1 + $2 }"
else
  echo 'Нужно ввести числа'
fi