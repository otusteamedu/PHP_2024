#!/bin/sh

if [ "$#" -gt 2 ]
then
  sum=$(( $1 + $2 ))
  echo "Too much args, current count is $#";
  exit 1
fi

if [ "$#" -lt 2 ]
then
  echo "Not enough args, current count is $#";
  exit 1
fi

regex='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $regex ]] ; then
   echo "Arg $1 is not correct number"
   exit 1
fi

if ! [[ $2 =~ $regex ]] ; then
   echo "Arg $2 is not correct number"
   exit 1
fi

perl -E "say $1+$2"
