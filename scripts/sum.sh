#! /bin/bash
check_arg()
{
  if ! [[ "$1" =~ ^[-+]?[0-9]*$ || "$1" =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]
    then
  echo "error: first argument must be number"
  exit 2
fi
}
check_arg $1
check_arg $2
sum=$(awk "BEGIN {print $1+$2; exit}")
echo $sum