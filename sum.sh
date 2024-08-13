#!/bin/bash

if [[ $# != 2 ]]; then
  echo "2 arguments are required";
  exit 1;
fi

re='^-?[0-9](\.[0-9])?+$'
if ! [[ $1 =~ $re && $2 =~ $re ]] ; then
   echo "Arguments must be numbers";
   exit 1;
fi

awk "BEGIN{ print $1 + $2 }";
