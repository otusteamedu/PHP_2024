#!/bin/sh

awk '{ print $3 }' users.txt |tail -n +2  | sort | uniq -c | sort -b -n -r | head -n 3
