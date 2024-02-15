#!/bin/bash

if [ $# -ne 2 ]; then
	echo "Дай мне два числа, которые разделены пробелом :)"
	exit
fi

num1=$(echo "$1" | sed 's/,/./')

num2=$(echo "$2" | sed 's/,/./')

if ! [[ $num1 =~ ^-?[0-9]+(\.[0-9]+)?$ ]] || ! [[ $num2 =~ ^-?[0-9]+(\.[0-9]+)?$ ]]; then
	echo "Мне не удалось распознать передаваемые числа :("
	exit
fi

sum=$(awk "BEGIN {print $num1 + $num2}")

echo "Ответ: $sum"