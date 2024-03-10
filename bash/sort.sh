#!/bin/bash

awk '{ print $3 }' './sort.txt' | tail -n+2 | sort | uniq -c | sort -nr | awk '{ print $2 }' | head -3;
exit 0