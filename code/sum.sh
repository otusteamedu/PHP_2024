#!/bin/env bash

args=2

if [[ $# -ne args ]]
then
  echo 'Error! 2 arguments is required!'
  exit
fi

if ! [[ $1 =~ [0-9] ]] || [[ $1 =~ [a-zA-Z] ]]
then
  echo 'ERROR! Argument 1 is not a number!'
  exit
fi

if ! [[ $2 =~ [0-9] ]] || [[ $2 =~ [a-zA-Z] ]]
then
  echo 'ERROR! Argument 2 is not a number!'
  exit
fi

echo "$1 $2" | awk '{print $1 + $2}'
