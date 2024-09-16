#!/bin/bash

if [ -z $2 ] || [ -z $1 ] || [ $# -ne 2 ]; then
  echo "Wrong params"; exit 1;
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $2 =~ $re ]] || ! [[ $1 =~ $re ]]; then
  echo "error: Not a number" >&2; exit 1
fi

echo `awk -v y1=$1 -v y2=$2 'BEGIN {print y1+y2}'`
