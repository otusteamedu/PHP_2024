#!/bin/bash
if [ $# -eq 0 ]
then 
	echo 'Incorrect script launch.'
   echo 'Argument must be a file name container list of cities'
	exit 1
fi

if [ $# -ne 1 ]
then 
	echo 'Is not 1 argument. Enter file name contained list of cities'
	exit 1
fi

file=$1

if [ ! -f "$file" ]; then
   echo "File $file not found"
   exit 1
fi

cities=$(awk 'NR>1 {print $3}' "$file" | sort | uniq -c | sort -nr)

echo "Three most popular cities"
echo "  Count City"

echo "$cities" | head -n 3

