#!/usr/bin/env bash

pattern='^[-?0-9]+(\.[0-9]+)?$'

if ! bc -v &> /dev/null
then
    echo "bc utility could not be found"
    exit 1
fi

if ! [[ $1 =~ $pattern ]]
then
  echo "Invalid first argument: \"$1\"" >&2 && exit 1
fi

if ! [[ $2 =~ $pattern ]]
then
  echo "Invalid second argument: \"$2\"" >&2 && exit 1
fi

echo $(echo "$1 + $2" | bc)
