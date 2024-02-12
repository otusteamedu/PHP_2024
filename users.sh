#!/bin/sh

awk '{ print $3 }' users.txt  | sort | uniq -c | sort -b -n -r | head -n 3
