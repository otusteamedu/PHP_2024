#!/bin/bash

# IMPORTANT
# return true === return 0, return false === return 1
# exit 1 means error (false)

if [ $# -ne 2 ]; then
  echo 'There should be two arguments like ./sum.sh 11 21';
  exit 1;
fi

function isEmpty() {
  echo "function isEmpty checking value" $1;

  if [ -z "$1" ]; then
    echo 'function isEmpty return 1';
    return 1;
  fi

  echo 'function isEmpty return 0';
  return 0;
}

if isEmpty "$1" ; then
    echo "#1 not empty";
  else
    echo "#1 is empty";
    exit 1;
fi

if isEmpty "$2" ; then
    echo "#2 not empty";
  else
    echo "#2 is empty";
    exit 1;
fi

function isNumber() {
  echo 'function isNumber checking value "'"$1"'"';

  if  [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
    echo "yes it's a number";
    return 0;
  fi

  echo "no it's not a number";
  return 1;
}

if ! isNumber "$1"; then
  echo '#1 is not number';
  exit 1;
fi

if ! isNumber "$2"; then
  echo '#2 is not number';
  exit 1;
fi

function echoSumAWK() {
  local num=$(awk "BEGIN{ print $1 + $2 }")
  echo 'Sum using awk is' $num;
}

echoSumAWK $1 $2

function echoSumBC() {
  local num=$(echo $1+$2|bc)
  echo 'Sum using BC is ' $num;
}

echoSumBC $1 $2;