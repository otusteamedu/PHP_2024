#!/bin/bash

echo "$(awk '{NR>1 && items[$3]++} END {for (key in items) print items[key], key}' ./data.txt | sort -r | head -n 3 | awk '{print $2}')"
