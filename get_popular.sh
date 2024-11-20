#!/bin/bash

filename=$1
if [ -z "$filename" ]; then
  filename="users.txt"
fi

if ! [ -r "$filename" ]; then
  echo "Файл $filename отсутствует или нет прав для его чтения"; exit 1;
fi

cities=$(awk '{print $3}' "$filename" | sed -E 's|city||g' | sort | uniq -c | sort -r | head -n 3 | awk '{print $2}');

echo "$cities"