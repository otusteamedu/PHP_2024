#!/bin/bash

awk '{NR>1 && a[$3]++} END {for (i in a) print a[i] " " i}' ./table.txt | sort -nr | head -n 3 | awk '{print $2}'