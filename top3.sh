#!/bin/bash

awk '{NR>1 && count[$3]++} END {for (word in count) print word, count[word]}' ./table.txt | sort -rk 2 | head -n 3 | awk '{print $1}'