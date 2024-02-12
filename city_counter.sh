#!/bin/bash
printMessageAndExit () {
   for message in "$@"; do
		echo "$message" >&2
	done
   exit 1
}

if [ $# -eq 0 ]
then
	printMessageAndExit 'Incorrect script launch.' 'The argument must be a file name containing a list of cities.'
fi

if [ $# -ne 1 ]
then
	printMessageAndExit 'This is not a single argument. Please enter the file name containing the list of cities.'
fi

file=$1

if [ ! -f "$file" ]; then
	printMessageAndExit "File $file not found"
fi

cities=$(awk 'NR>1 {print $3}' "$file" | sort | uniq -c | sort -nr)

echo "Three most popular cities"
echo "  Count City"

echo "$cities" | head -n 3
