#!/bin/bash

if ! [[ -n "$1"  ]] || ! [[ -n "$2" ]]
then
	echo "Parameters did not found. "
	exit
elif ! [[ "$1" =~ (^\-?\+?)([0-9\.?]+)$ ]] || ! [[ "$2" =~ (^\-?\+?)([0-9\.?]+)$ ]]
then
	echo "Error: Need digit parameters. "
	exit
fi

x=$1
y=$2

awk "BEGIN {print ($x)+($y)}"
