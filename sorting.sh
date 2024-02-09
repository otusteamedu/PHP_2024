#!/usr/bin/bash

if [ ! -f "$1" ]
then
    echo "file '$1' does not exist."
    exit 1
fi
file=$(sort -k3 "$1" | awk '{print $3}' | uniq -d)
echo "Popular cities:"
echo "$file" | sed "/^$/d"