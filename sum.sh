#!/bin/bash
#Проверка на к-во агрументов
if [ "$#" != 2 ]
then
    echo "К-во аргументов должно быть два"
    exit 1
fi

#Проверка аргументов на валидность и сложение
re='^-?[0-9]+\.?[0-9]*$'
sum=0;
for arg in "$@"
do
  if ! [[ $arg =~ $re ]] ; then
         echo "Аргумент $arg не валиден"
         exit 1
  fi
  sum=$(bc<<<"scale=3;$sum+$arg")
done

#вывод
echo $sum