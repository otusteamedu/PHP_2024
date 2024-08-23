#!/bin/bash

if [ $# -lt 2 ]
  then
    echo "Введите два слагаемых!";
    exit;
fi;

if [ $# -gt 2 ]
  then
    echo "Скрипт умеет считать только два слагаемых!";
    exit;
fi;

separator=$(locale decimal_point);
re="^[-]?[0-9]+([${separator}][0-9]+)?$"
if ! [[ $1 =~ $re ]]
  then
     echo "Первое слагаемое - не число!";
     exit;
fi;

if ! [[ $2 =~ $re ]]
  then
    echo "Второе слагаемое - не число!";
  exit;
fi;

echo "$1 $2" | awk '{sum=$1+$2} END {print sum}';
