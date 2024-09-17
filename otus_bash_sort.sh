#!/bin/bash

if [ ! -f "$1" ]       # Проверка существования файла.
then
  echo "Файл \"$1\" не найден."
  exit $E_NOFILE
fi

printCities=$( awk '{print $3}' $1 | sort | uniq -d )
if ! [ -n "$printCities" ]
then awk 'FNR>1 {print $3}' $1 | head -3
else awk '{print $3}' $1 | sort | uniq -d | head -3
fi