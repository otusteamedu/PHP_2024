#!/bin/bash

awk 'BEGIN {print "Топ 3 городов из таблицы:"}'
cat table.txt | tail -n +2 | awk '!/^[[:space:]]*$/' | awk '{print $3}' | sort | uniq -c | sort -r | head -n3