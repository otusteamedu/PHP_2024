#!/usr/bin/env bash

colnum=$(head -n1 "$1" | awk -v RS=" " '/city/ { print NR }')

tail -n+2 "$1" \
    | cut -d' ' -f"$colnum" \
    | sort \
    | uniq -c \
    | sort -nr \
    | head -n3 \
    | awk '{ print $NF }'

