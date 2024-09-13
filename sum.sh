#!/bin/bash

ARGUMENTS_LIMIT=2
ARGUMENTS_ARRAY=("$@")
SUM=0
ERROR=0

if [ $# -lt "$ARGUMENTS_LIMIT" ]
then
  let "ERROR++"
  echo "Ошибка! Нужно ввести чисел: $ARGUMENTS_LIMIT, введено: ${#ARGUMENTS_ARRAY[@]}"
  ARGUMENTS_LIMIT=${#ARGUMENTS_ARRAY[@]}
fi

if [ $# -gt "$ARGUMENTS_LIMIT" ]
then
  let "ERROR++"
  echo "Ошибка! Можно сложить чисел: $ARGUMENTS_LIMIT, введено: ${#ARGUMENTS_ARRAY[@]}"
fi

for (( i=0; i < ARGUMENTS_LIMIT; i++ ))
do
  if [[ ${ARGUMENTS_ARRAY[$i]} =~ ^[-]?[0-9]+[.]?[0-9]?+$ ]]
  then
    [ $ERROR = 0 ] && SUM=$(awk "BEGIN {print $SUM +  ${ARGUMENTS_ARRAY[$i]} }")
  else
    let "ERROR++"
    echo "Ошибка! ${ARGUMENTS_ARRAY[$i]} не является числом"
  fi
done

[ "$ERROR" = 0 ] && echo "Сумма равна $SUM"