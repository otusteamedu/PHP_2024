#!/bin/bash

echo "Калькулятор"
echo "Введите выражение для вычисления. Пример: 1 + 2"
read -ra args

if ! [ "${#args[@]}" = "3" ]; then
  echo "Передано неверное выражение."
  exit 1
fi

operand1="${args[0]}"
operation="${args[1]}"
operand2="${args[2]}"

operandNum=1
for operand in $operand1 $operand2; do
  if ! [[ "$operand" =~ ^[0-9.+-]+$ ]]; then
    echo "Неверное значение $operandNum-го операнда. Доступны только числовые значения. Пример: 1, -1, 1.65, -3.56"
    exit 1
  fi
  operandNum=$(( operandNum + 1 ))
done

if ! [[ "$operation" =~ ^[+/*-]$ ]]; then
    echo "Не верное значение операции. Доступны значения: *, /, +, -"
    exit 1
fi

if [[ "$operation" = "/" && "$operand2" = "0" ]]; then
  res=0
else
  res=$(awk "BEGIN { res = $operand1 $operation $operand2; print res }" | tr ',' '.')
fi

echo "Результат: $operand1 $operation $operand2 = $res"

