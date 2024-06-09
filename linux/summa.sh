#!/bin/bash

NUM1=$1
NUM2=$2

if ! [[ $NUM1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]] ; then
   echo "error: Option #1 is not a number" >&2; exit 1
fi

if ! [[ $NUM2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]] ; then
   echo "error: Option #2 is not a number" >&2; exit 1
fi

echo "$NUM1 + $NUM2" | awk -F " " '{sum = $1 + $3}; END {print sum}'