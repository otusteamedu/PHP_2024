#!/bin/bash

if [ $# -eq 0 ]; then
	echo "No arguments"
	exit
fi

if [ -z "$2" ]; then
	echo "Requires at least 2 arguments"
        exit
fi

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re && $2 =~ $re ]]; then
    echo "Parameters must be of numeric type"
    exit
fi

echo $1 $2 | awk '{print $1 + $2}'