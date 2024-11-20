#!/bin/bash

FILE_1=$(mktemp)
FILE_2=$(mktemp)
COLUMN_NAME=city
CITIES_LIMIT=3
ORIGIN=user.txt

awk '{print $3}' "$ORIGIN" > "$FILE_1"
awk '/\S/' "$FILE_1" > "$FILE_2"
awk "!/$COLUMN_NAME/" "$FILE_2" > "$FILE_1"
sort "$FILE_1" | uniq -c > "$FILE_2"
sort -r "$FILE_2" > "$FILE_1"
head -n "$CITIES_LIMIT" "$FILE_1"
rm "$FILE_1" "$FILE_2"
