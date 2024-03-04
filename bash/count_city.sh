#!/bin/bash

if [ $# -ne 1 ]; then
    echo 'file path is required'
    exit 1;
fi

if ! [ -f $1 ]; then
  echo 'File not found'
  exit 1;
fi

echo 'Reading file' $1; ':';
awk 'NR>1 {print $0}' "$1";

echo -e;
echo -e "let's search best one";
echo -e;

#CITY=$(awk 'NR>1 {print $3}' "$1" | sort | uniq -c | sort -nr)
CITY=$(awk 'NR>1 {print $3}' "$1")

echo "Get third column as list:"
echo "$CITY" | sort;
echo -e;
echo "Get only unique and count:"
echo "$CITY" | sort | uniq -c;
echo -e;
echo "Sort items by count:"
echo "$CITY" | sort | uniq -c | sort -nr;
echo -e;
echo -e;
echo "Top three city:"

SORTED=$(awk 'NR>1 {print $3}' "$1" | sort | uniq -c | sort -nr);

echo "$SORTED" | head -n 3

exit 0;