#!/bin/bash

echo `awk '{print $3,$4}' sort.txt | sort -nrk2  | awk -F\  '{if (!a[$1]++ ) print $1, $2}' | head -3`
