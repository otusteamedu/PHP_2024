#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo "Only 1 argument is accepted."
  exit 1
fi

filename=$1

if [ ! -f "$filename" ]; then
  echo "File $filename not found!"
  exit 1
fi

awk 'NR>1 {print $3}' "$filename" | sort | uniq -c | sort -nr | head -n 3