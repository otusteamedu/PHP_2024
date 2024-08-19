#!/bin/bash

checkbc=$(dpkg-query -s bc 2> /dev/null)
if [ -z "$checkbc" ]
  then
      echo "Установите bc!";
      exit;
fi;

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

re='^[-]?[0-9]+([.][0-9]+)?$'
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

sum=$(echo "$1 + $2" | bc);
echo $sum;
