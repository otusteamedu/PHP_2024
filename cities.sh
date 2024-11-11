#!/bin/bash

awk 'NR>1 {print $3}' ./data.txt | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2 ": " $1}'