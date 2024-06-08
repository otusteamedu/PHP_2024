#!/bin/sh -

if [ $# = 1 ] & [ -e $1 ]
then
	awk '{print $3}' $1 | sort | uniq -c | sort -r | head -3 | awk '{print $2}'
else
	echo "ERROR: Invalid arguments"
fi
