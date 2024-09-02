#!/usr/bin/env bash

POPULAR_CITIES=$(awk '{print $3}' cities.txt | tail -n +2 | sort | uniq -c | sort -r | head -3)

echo -e "The most popular cities are:\n${POPULAR_CITIES}"
