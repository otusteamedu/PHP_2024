#!/bin/bash
if [ $# -eq 0 ]
then 
	echo 'Incorrect script launch.'
	echo 'Launch script with two number arguments'
	exit 1
fi

if [ $# -ne 2 ]
then 
	echo 'Is not 2 arguments'
	exit 1
fi

if  [[ ! $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
then 
	echo "$1 is not a number" 
	exit 1
fi

if [[ ! $2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
then	
	echo "$2 is not a number"
	exit 1
fi

echo $1 $2 | awk '{print $1 + $2}'
