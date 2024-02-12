#!/bin/bash

filename="cities.txt"

if ! [ -f $filename ]; then
  echo "Файл $filename не существует!"
  exit 1
fi

awk 'NR>1 {print $3}' $filename | sort | uniq -c | sort -rnk1 | head -n 3 | awk '{print $2,$1}'
exit 0;