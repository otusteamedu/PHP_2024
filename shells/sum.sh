#!/bin/bash

if [[ ! $1 =~ ^(-?)([0-9]*)([.,]?[0-9]+)$ ]];
    then echo -e "\e[1;31m First argument not number \e[0m" >&2; exit 1
fi

if [[ ! $2 =~ ^(-?)([0-9]*)([.,]?[0-9]+)$ ]];
    then echo -e "\e[1;31m Second argument not number \e[0m" >&2; exit 1
fi

awk -v a=$1 -v b=$2 '
BEGIN {
  print "\033[32m SUM: ", (a + b)
}';