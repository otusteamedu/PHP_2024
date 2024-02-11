#!/usr/bin/env bash

REGEX='^(-)?[0-9]+(\.[0-9]+)?$'

for arg in "$@"; do
  if ! [[ $arg =~ $REGEX ]]; then
    echo "Ошибка. Передан неправильный аргумент. Аргумент должен быть числом."
    exit 1
  fi
done

SUMMA=0

for arg in "$@"; do
  SUMMA=$(awk "BEGIN {print $SUMMA+$arg}")
done

echo $SUMMA