#!/bin/bash

if [ ! -f "$1" ]       # Проверка существования файла.
then
  echo "Файл \"$1\" не найден."
  exit $E_NOFILE
fi

awk '{print $3}' $1 | sort | uniq -d | head -3