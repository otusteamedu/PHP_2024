#!/bin/bash
if [ "$#" != 2 ]
then
    echo "К-во аргументов должно быть два"
    exit 1
fi

#Проверка аргументов на валидность
re='^-?[0-9]+\.?[0-9]*$'
for arg in "$@"
do
  if ! [[ $arg =~ $re ]] ; then
         echo "Аргумент $arg не валиден"
         exit 1
  fi
done

#вывод
echo $(awk "BEGIN{ print $1 + $2 }")