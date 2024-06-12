#!/bin/sh

filename="cities.txt"

if [ ! -f "$filename" ]; then
  echo "File $filename does not exist."
  exit 1
fi

popularCities=$(awk '{print $3}' "$filename" | tail -n +2 | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2}')

if [ -z "$popularCities" ]; then
  echo "No cities found in the file."
  exit 1
fi

echo "Top 3 most popular cities:"
echo "$popularCities"