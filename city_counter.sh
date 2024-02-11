#!/bin/bash

if [ $# -ne 1 ]; then
    echo "Give me the file!"
    exit 1
fi

if [ ! -f "$1" ]; then
   echo "File $1 not found"
   exit 1
fi

awk '{print $3}' "$1" | sort | uniq -ci | sort -r | awk '{print NR,$2}' | head -3