#! /bin/bash

sort sort.txt | sort -nrk 4  |uniq | awk '{print $3}' | head -n 3