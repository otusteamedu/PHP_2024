#!/bin/bash

grep -v '^$' data.txt | awk '{print $3}' | sort -r | uniq -c | sort -rn | awk '{print $2}' | head -n 3