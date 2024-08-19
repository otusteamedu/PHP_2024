#!/bin/bash

if [ $# -ne 1 ]
  then
    echo 'Укажите файл с данными(cities.txt)';
    exit;
fi;

awk 'NR>1 {print $3}' $1 | sort -r | uniq -c | sort -r | head -3 | awk '{print $2}'