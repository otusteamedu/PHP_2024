#!/bin/sh

if [ -z "$1" ]; then
  echo "There is no params sended, program finished..."
  exit
elif [ -z "$2" ]; then
  echo "There is no second param, program finished..."
  exit
elif [ -z "$3" ]; then
  for i in $1 $2
  do
    pattern=$(echo $i | awk '/^[+-]?[0-9]+([.][0-9]+)?$/{print $0}')
    if [ -z $pattern ] ; then
      echo "error: $i is not a number, program finished..."; exit
    fi
  done
else
  echo "There are too much params, program finished..."
  exit
fi

a=$1
b=$2
echo $a $b | awk '{ print $1+$2 }'