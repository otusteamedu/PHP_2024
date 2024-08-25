#!/bin/sh

function check_is_number {
  re='^[+-]?[0-9]+([.][0-9]+)?$'
  if [ -z $var1 ] ; then
    echo "${2}st variable is empty"
    exit 1
  elif ! [[ $var1 =~ $re ]] ; then
    echo "${2}st variable not a number"
    exit 1
  fi
}

var1=$1
check_is_number 1
var1=$2
check_is_number 2

echo "$1 $2" | awk '{sum=$1+$2} END {print sum}'