#!/bin/bash

MAX_ARG_COUNT=2

if [[ $# -ne $MAX_ARG_COUNT ]]; then

  usage="$0"
  for ((i = 1; i <= $MAX_ARG_COUNT; i++)); do
    usage+=" arg$i"
  done

  echo "Ошибка. Ожидается $MAX_ARG_COUNT аргумента(-ов), передано: $#. Пример использования: $usage"
  exit 1
fi

NUMBERS_REGEX='^(-)?[0-9]+(\.[0-9]+)?$'

for arg in "$@"; do
  if ! [[ $arg =~ $NUMBERS_REGEX ]]; then
    echo "Ошибка. Передан неверный аргумент: \"$arg\". Аргумент должен быть числом."
    exit 1
  fi
done

SUM=0

for arg in "$@"; do
  SUM=$(awk "BEGIN {print $SUM+$arg}")
done

echo $SUM
