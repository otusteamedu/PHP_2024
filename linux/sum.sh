#!/bin/sh -

is_num() { case ${1#[-+]} in '' | . | *[!0-9.]* | *.*.* ) return 1;; esac ;}

if [ $# = 2 ] && is_num $1 && is_num $2
then
	awk "BEGIN { print $1 + $2 }"
else
	echo "ERROR: Invalid arguments"
fi