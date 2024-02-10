#!/bin/bash

echo "Sorter is starting..."
if [ "$#" -ne 1 ]
then
  echo "You must enter a path to file as argument of command!"
  exit 1
fi
if ! [[ -f "$1" ]]
then
  echo "Argument is not a file!"
  exit 1
fi
headerPattern='id user city phone'
header=$(head -1 $1)
if ! [ "$header" = "$headerPattern" ]
then
  echo "The file content is not compatible!"
  exit 1
fi
echo "The most popular cities:"
awk 'length { print $3 }' $1 | tail -n +2 | sort | uniq -c | sort -rnk1 | awk '{ print $2 }' | head -3
