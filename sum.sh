#!/bin/bash

NUM1=$(echo $1 | awk '/^-?[0-9]+([.][0-9]+)?$/{print $0}')
NUM2=$(echo $2 | awk '/^-?[0-9]+([.][0-9]+)?$/{print $0}')

if [ -z "$NUM1" ] ;
then
  echo "First number is invalid"
  exit 0
fi

if [ -z "$NUM2" ] ;
then
  echo "Second number is invalid"
  exit 0
fi

RESULT=$(awk "BEGIN {print $NUM1 + $NUM2}")

echo $RESULT
